<?php

namespace Filafly\Icons\Tabler\Tests;

use BladeUI\Icons\Factory;
use Filafly\Icons\Tabler\Enums\Tabler;
use Filafly\Icons\Tabler\Enums\TablerStyle;
use Filafly\Icons\Tabler\TablerIcons;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Enums\IconSize;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\IconManager;
use InvalidArgumentException;
use ReflectionClass;

class TablerIconsTest extends TestCase
{
    /**
     * Every alias Filament defines in its *IconAlias classes, read from the installed version.
     *
     * @return array<string, string> constant => alias
     */
    public static function filamentAliases(): array
    {
        $aliases = [];

        foreach (glob(dirname(__DIR__).'/vendor/filament/*/src/View/*IconAlias.php') as $file) {
            preg_match('/^namespace\s+([^;]+);/m', file_get_contents($file), $matches);
            $class = $matches[1].'\\'.basename($file, '.php');

            foreach ((new ReflectionClass($class))->getConstants() as $name => $alias) {
                $aliases[class_basename($class).'::'.$name] = $alias;
            }
        }

        return $aliases;
    }

    /**
     * Filament's own alias normalization, or the alias unchanged on 4.0 and 4.1,
     * which have no normalizeAlias() and no renamed keys.
     */
    private static function normalize(string $alias): string
    {
        return method_exists(IconManager::class, 'normalizeAlias')
            ? IconManager::normalizeAlias($alias)
            : $alias;
    }

    /** @return array<string, Tabler> */
    private function iconMap(): array
    {
        $property = (new ReflectionClass(TablerIcons::class))->getProperty('iconMap');

        return $property->getValue(new TablerIcons);
    }

    public function test_it_finds_filaments_alias_classes(): void
    {
        $this->assertGreaterThan(100, count(self::filamentAliases()), 'Filament 4.0 defines 141 aliases');
    }

    public function test_every_filament_alias_is_mapped(): void
    {
        $mapped = array_map(self::normalize(...), array_keys($this->iconMap()));

        $missing = array_filter(
            self::filamentAliases(),
            fn (string $alias): bool => ! in_array(self::normalize($alias), $mapped, true),
        );

        $this->assertSame([], $missing, 'Filament aliases with no Tabler icon: '.implode(', ', array_keys($missing)));
    }

    public function test_icons_are_mapped_to_their_outline_version(): void
    {
        foreach ($this->iconMap() as $alias => $icon) {
            $this->assertInstanceOf(Tabler::class, $icon, "{$alias} is not mapped to a Tabler case");
            $this->assertFalse(str_ends_with($icon->value, '-filled'), "{$alias} is mapped to a fill icon");
        }
    }

    public function test_every_enum_case_has_an_svg_in_blade_tabler_icons(): void
    {
        $factory = app(Factory::class);
        $missing = [];

        foreach (Tabler::cases() as $case) {
            try {
                $factory->svg($case->getIconForSize(IconSize::Medium));
            } catch (\Throwable) {
                $missing[] = $case->value;
            }
        }

        $this->assertSame([], $missing, 'Enum cases with no SVG: '.implode(', ', $missing));
    }

    public function test_enum_cases_resolve_to_the_tabler_blade_prefix(): void
    {
        $this->assertSame('tabler-trash', Tabler::Trash->getIconForSize(IconSize::Small));
        $this->assertSame('tabler-home-filled', Tabler::HomeFilled->getIconForSize(IconSize::Large));
    }

    public function test_registering_replaces_filaments_icons_with_regular_icons(): void
    {
        TablerIcons::make()->registerIcons();

        $this->assertSame('tabler-search', FilamentIcon::resolve('panels::global-search.field'));
        $this->assertSame('tabler-trash', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('tabler-bold', FilamentIcon::resolve('forms:components.rich-editor.toolbar.bold'));
        $this->assertSame('tabler-typography', FilamentIcon::resolve('tables::filters.query-builder.constraints.text'));

        foreach (self::filamentAliases() as $constant => $alias) {
            $this->assertStringStartsWith('tabler-', (string) FilamentIcon::resolve($alias), "{$constant} is not a Tabler icon");
        }
    }

    public function test_filled_switches_every_icon_that_has_a_fill_version(): void
    {
        TablerIcons::make()->filled()->registerIcons();

        $this->assertSame('tabler-home-filled', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
        $this->assertSame('tabler-trash-filled', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('tabler-bold', FilamentIcon::resolve('forms:components.rich-editor.toolbar.bold'));

        foreach ($this->iconMap() as $alias => $icon) {
            $expected = Tabler::tryFrom("{$icon->value}-filled") ?? $icon;

            $this->assertSame("tabler-{$expected->value}", FilamentIcon::resolve($alias), "{$alias} has the wrong filled icon");
        }
    }

    public function test_style_can_be_overridden_per_alias_and_per_icon_without_a_global_style(): void
    {
        TablerIcons::make()
            ->overrideStyleForAlias('actions::delete-action', TablerStyle::Filled)
            ->overrideStyleForIcon(Tabler::Search, 'filled')
            ->registerIcons();

        $this->assertSame('tabler-trash-filled', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('tabler-trash', FilamentIcon::resolve('actions::force-delete-action'));
        $this->assertSame('tabler-search-filled', FilamentIcon::resolve('tables::search-field'));
        $this->assertSame('tabler-home', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
    }

    public function test_outline_can_be_kept_for_some_icons_when_the_rest_are_filled(): void
    {
        TablerIcons::make()
            ->filled()
            ->overrideStyleForAlias(['actions::delete-action', 'actions::edit-action'], 'outline')
            ->registerIcons();

        $this->assertSame('tabler-trash', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('tabler-edit', FilamentIcon::resolve('actions::edit-action'));
        $this->assertSame('tabler-trash-filled', FilamentIcon::resolve('actions::force-delete-action'));
    }

    public function test_aliases_and_icons_can_be_overridden(): void
    {
        TablerIcons::make()
            ->overrideAlias('actions::delete-action', Tabler::Eraser)
            ->overrideIcons([Tabler::Search->value => Tabler::ZoomScanFilled])
            ->registerIcons();

        $this->assertSame('tabler-eraser', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('tabler-trash', FilamentIcon::resolve('actions::force-delete-action'));
        $this->assertSame('tabler-zoom-scan-filled', FilamentIcon::resolve('tables::search-field'));
    }

    public function test_legacy_query_builder_keys_do_not_overwrite_an_override(): void
    {
        TablerIcons::make()
            ->overrideAlias('query-builder::constraints.text', Tabler::Star)
            ->registerIcons();

        $this->assertSame('tabler-star', FilamentIcon::resolve('query-builder::constraints.text'));
        $this->assertSame('tabler-hash', FilamentIcon::resolve('query-builder::constraints.number'));
    }

    public function test_legacy_query_builder_keys_are_kept_only_where_filament_uses_them(): void
    {
        $map = $this->iconMap();
        $legacy = 'tables::filters.query-builder.constraints.text';

        if (self::normalize($legacy) === $legacy) {
            $this->assertArrayHasKey($legacy, $map, 'Filament without the renamed keys still needs the legacy one');
        } else {
            $this->assertArrayNotHasKey($legacy, $map, 'The legacy key would overwrite the current one');
            $this->assertArrayHasKey(self::normalize($legacy), $map);
        }
    }

    public function test_rich_editor_toolbar_aliases_are_mapped(): void
    {
        // Filament's own toolbar constants (only in later 4.x releases), so a renamed
        // prefix shows up here instead of silently falling back to Heroicons.
        $toolbar = array_filter(
            self::filamentAliases(),
            fn (string $constant): bool => str_contains($constant, 'RICH_EDITOR_TOOLBAR_'),
            ARRAY_FILTER_USE_KEY,
        );

        if ($toolbar === []) {
            $this->markTestSkipped('This Filament version has no rich editor toolbar aliases.');
        }

        TablerIcons::make()->registerIcons();

        foreach ($toolbar as $constant => $alias) {
            $this->assertArrayHasKey($alias, $this->iconMap(), "{$constant} is not in the icon map");
            $this->assertStringStartsWith('tabler-', FilamentIcon::resolve($alias), "{$constant} is not a Tabler icon");
        }
    }

    public function test_unknown_styles_are_rejected(): void
    {
        $this->assertSame(['outline', 'filled'], TablerIcons::make()->getAvailableStyleNames());

        $this->expectException(InvalidArgumentException::class);

        TablerIcons::make()->style('duotone');
    }

    public function test_the_plugin_registers_icons_when_a_panel_boots(): void
    {
        $panel = Panel::make()->id('admin')->default()->plugin(TablerIcons::make()->filled());
        Filament::registerPanel($panel);

        $panel->getPlugin('filafly-filament-tabler-icons')->boot($panel);

        $this->assertSame('tabler-home-filled', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
    }
}
