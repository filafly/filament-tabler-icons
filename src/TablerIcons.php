<?php

namespace Filafly\Icons\Tabler;

use Filafly\Icons\IconSet;
use Filafly\Icons\Tabler\Enums\Tabler;
use Filafly\Icons\Tabler\Enums\TablerStyle;
use Filament\Support\Icons\IconManager;

class TablerIcons extends IconSet
{
    protected string $pluginId = 'filafly-filament-tabler-icons';

    protected mixed $iconEnum = Tabler::class;

    protected string $iconPrefix = 'tabler';

    protected mixed $styleEnum = TablerStyle::class;

    /** Outline is the default, so style overrides work without calling outline() first. */
    protected mixed $currentStyle = TablerStyle::Outline;

    public function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct();
        }

        // Filament 4.2+ renames the 4.0 and 4.1 tables:: query builder keys to query-builder::
        // when they're registered. Registering both would let the legacy key overwrite
        // an overrideAlias() on the current one, so keep a legacy key only where
        // Filament still treats it as its own alias.
        if (! method_exists(IconManager::class, 'normalizeAlias')) {
            return;
        }

        foreach (array_keys($this->iconMap) as $alias) {
            $normalized = IconManager::normalizeAlias($alias);

            if ($normalized !== $alias && array_key_exists($normalized, $this->iconMap)) {
                unset($this->iconMap[$alias]);
            }
        }
    }

    /**
     * Every Filament 4 and 5 icon alias, mapped to a Tabler icon.
     *
     * Keys are the alias strings rather than the *IconAlias constants, because
     * several constants (rich editor toolbar, multi-factor auth, callouts, query
     * builder) only exist in later 4.x releases. String keys keep the map loadable
     * on every Filament version the package supports.
     *
     * Icons are mapped to their outline version. filled() switches every icon that
     * has a -filled version; the rest stay as they are.
     */
    protected array $iconMap = [
        // Panels
        'panels::auth.multi-factor.app.actions.disable' => Tabler::ShieldX,
        'panels::auth.multi-factor.app.actions.disable.modal' => Tabler::ShieldX,
        'panels::auth.multi-factor.app.actions.disable.notification' => Tabler::ShieldX,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes' => Tabler::Refresh,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes.modal' => Tabler::Refresh,
        'panels::auth.multi-factor.app.actions.regenerate-recovery-codes.notification' => Tabler::Key,
        'panels::auth.multi-factor.app.actions.set-up' => Tabler::ShieldCheck,
        'panels::auth.multi-factor.app.actions.set-up.modal' => Tabler::ShieldCheck,
        'panels::auth.multi-factor.app.actions.set-up.notification' => Tabler::ShieldCheck,
        'panels::auth.multi-factor.email.actions.disable' => Tabler::MailX,
        'panels::auth.multi-factor.email.actions.disable.modal' => Tabler::MailX,
        'panels::auth.multi-factor.email.actions.disable.notification' => Tabler::MailX,
        'panels::auth.multi-factor.email.actions.set-up' => Tabler::MailCheck,
        'panels::auth.multi-factor.email.actions.set-up.modal' => Tabler::MailCheck,
        'panels::auth.multi-factor.email.actions.set-up.notification' => Tabler::MailCheck,
        'panels::global-search.field' => Tabler::Search,
        'panels::pages.dashboard.actions.filter' => Tabler::Filter,
        'panels::pages.dashboard.navigation-item' => Tabler::Home,
        'panels::pages.password-reset.request-password-reset.actions.login' => Tabler::ArrowLeft,
        'panels::pages.password-reset.request-password-reset.actions.login.rtl' => Tabler::ArrowRight,
        'panels::resources.pages.edit-record.navigation-item' => Tabler::Edit,
        'panels::resources.pages.manage-related-records.navigation-item' => Tabler::LayoutGrid,
        'panels::resources.pages.view-record.navigation-item' => Tabler::Eye,
        'panels::sidebar.collapse-button' => Tabler::ChevronLeft,
        'panels::sidebar.collapse-button.rtl' => Tabler::ChevronRight,
        'panels::sidebar.expand-button' => Tabler::ChevronRight,
        'panels::sidebar.expand-button.rtl' => Tabler::ChevronLeft,
        'panels::sidebar.group.collapse-button' => Tabler::ChevronUp,
        'panels::sidebar.open-database-notifications-button' => Tabler::Bell,
        'panels::sub-navigation.mobile-menu.button' => Tabler::ChevronDown,
        'panels::tenant-menu.billing-button' => Tabler::CreditCard,
        'panels::tenant-menu.profile-button' => Tabler::Settings,
        'panels::tenant-menu.registration-button' => Tabler::Plus,
        'panels::tenant-menu.toggle-button' => Tabler::Selector,
        'panels::theme-switcher.dark-button' => Tabler::Moon,
        'panels::theme-switcher.light-button' => Tabler::Sun,
        'panels::theme-switcher.system-button' => Tabler::DeviceDesktop,
        'panels::topbar.close-sidebar-button' => Tabler::X,
        'panels::topbar.group.toggle-button' => Tabler::ChevronDown,
        'panels::topbar.open-database-notifications-button' => Tabler::Bell,
        'panels::topbar.open-sidebar-button' => Tabler::Menu2,
        'panels::user-menu.logout-button' => Tabler::Logout,
        'panels::user-menu.profile-item' => Tabler::UserCircle,
        'panels::user-menu.toggle-button' => Tabler::ChevronDown,
        'panels::widgets.account.logout-button' => Tabler::Logout,
        'panels::widgets.filament-info.open-documentation-button' => Tabler::Book,
        'panels::widgets.filament-info.open-github-button' => Tabler::BrandGithub,

        // Actions
        'actions::action-group' => Tabler::DotsVertical,
        'actions::create-action.grouped' => Tabler::Plus,
        'actions::delete-action' => Tabler::Trash,
        'actions::delete-action.grouped' => Tabler::Trash,
        'actions::delete-action.modal' => Tabler::Trash,
        'actions::detach-action' => Tabler::Unlink,
        'actions::detach-action.modal' => Tabler::Unlink,
        'actions::dissociate-action' => Tabler::Unlink,
        'actions::dissociate-action.modal' => Tabler::Unlink,
        'actions::edit-action' => Tabler::Edit,
        'actions::edit-action.grouped' => Tabler::Edit,
        'actions::export-action.grouped' => Tabler::Download,
        'actions::force-delete-action' => Tabler::Trash,
        'actions::force-delete-action.grouped' => Tabler::Trash,
        'actions::force-delete-action.modal' => Tabler::Trash,
        'actions::import-action.grouped' => Tabler::Upload,
        'actions::modal.confirmation' => Tabler::AlertTriangle,
        'actions::replicate-action' => Tabler::Copy,
        'actions::replicate-action.grouped' => Tabler::Copy,
        'actions::restore-action' => Tabler::Restore,
        'actions::restore-action.grouped' => Tabler::Restore,
        'actions::restore-action.modal' => Tabler::Restore,
        'actions::view-action' => Tabler::Eye,
        'actions::view-action.grouped' => Tabler::Eye,

        // Forms
        'forms::components.builder.actions.clone' => Tabler::Copy,
        'forms::components.builder.actions.collapse' => Tabler::ChevronUp,
        'forms::components.builder.actions.delete' => Tabler::Trash,
        'forms::components.builder.actions.edit' => Tabler::Edit,
        'forms::components.builder.actions.expand' => Tabler::ChevronDown,
        'forms::components.builder.actions.move-down' => Tabler::ArrowDown,
        'forms::components.builder.actions.move-up' => Tabler::ArrowUp,
        'forms::components.builder.actions.reorder' => Tabler::GripVertical,
        'forms::components.checkbox-list.search-field' => Tabler::Search,
        'forms::components.file-upload.editor.actions.drag-crop' => Tabler::Crop,
        'forms::components.file-upload.editor.actions.drag-move' => Tabler::ArrowsMove,
        'forms::components.file-upload.editor.actions.flip-horizontal' => Tabler::FlipVertical,
        'forms::components.file-upload.editor.actions.flip-vertical' => Tabler::FlipHorizontal,
        'forms::components.file-upload.editor.actions.move-down' => Tabler::CircleArrowDown,
        'forms::components.file-upload.editor.actions.move-left' => Tabler::CircleArrowLeft,
        'forms::components.file-upload.editor.actions.move-right' => Tabler::CircleArrowRight,
        'forms::components.file-upload.editor.actions.move-up' => Tabler::CircleArrowUp,
        'forms::components.file-upload.editor.actions.rotate-left' => Tabler::Rotate,
        'forms::components.file-upload.editor.actions.rotate-right' => Tabler::RotateClockwise,
        'forms::components.file-upload.editor.actions.zoom-100' => Tabler::ZoomReset,
        'forms::components.file-upload.editor.actions.zoom-in' => Tabler::ZoomIn,
        'forms::components.file-upload.editor.actions.zoom-out' => Tabler::ZoomOut,
        'forms::components.key-value.actions.delete' => Tabler::Trash,
        'forms::components.key-value.actions.reorder' => Tabler::GripVertical,
        'forms::components.modal-table-select.actions.select' => Tabler::Pointer,
        'forms::components.repeater.actions.clone' => Tabler::Copy,
        'forms::components.repeater.actions.collapse' => Tabler::ChevronUp,
        'forms::components.repeater.actions.delete' => Tabler::Trash,
        'forms::components.repeater.actions.expand' => Tabler::ChevronDown,
        'forms::components.repeater.actions.move-down' => Tabler::ArrowDown,
        'forms::components.repeater.actions.move-up' => Tabler::ArrowUp,
        'forms::components.repeater.actions.reorder' => Tabler::GripVertical,
        'forms::components.rich-editor.panels.custom-block.delete-button' => Tabler::Trash,
        'forms::components.rich-editor.panels.custom-block.edit-button' => Tabler::Edit,
        'forms::components.rich-editor.panels.custom-blocks.close-button' => Tabler::X,
        'forms::components.rich-editor.panels.merge-tags.close-button' => Tabler::X,
        'forms::components.select.actions.create-option' => Tabler::Plus,
        'forms::components.select.actions.edit-option' => Tabler::Edit,
        'forms::components.text-input.actions.copy' => Tabler::Copy,
        'forms::components.text-input.actions.hide-password' => Tabler::EyeOff,
        'forms::components.text-input.actions.show-password' => Tabler::Eye,
        'forms::components.toggle-buttons.boolean.false' => Tabler::X,
        'forms::components.toggle-buttons.boolean.true' => Tabler::Check,

        // Forms: rich editor toolbar (Filament's own aliases use a single colon here)
        'forms:components.rich-editor.toolbar.align-center' => Tabler::AlignCenter,
        'forms:components.rich-editor.toolbar.align-end' => Tabler::AlignRight,
        'forms:components.rich-editor.toolbar.align-justify' => Tabler::AlignJustified,
        'forms:components.rich-editor.toolbar.align-start' => Tabler::AlignLeft,
        'forms:components.rich-editor.toolbar.attach-files' => Tabler::Paperclip,
        'forms:components.rich-editor.toolbar.blockquote' => Tabler::Blockquote,
        'forms:components.rich-editor.toolbar.bold' => Tabler::Bold,
        'forms:components.rich-editor.toolbar.bullet-list' => Tabler::List,
        'forms:components.rich-editor.toolbar.clear_formatting' => Tabler::ClearFormatting,
        'forms:components.rich-editor.toolbar.code' => Tabler::Code,
        'forms:components.rich-editor.toolbar.code-block' => Tabler::SourceCode,
        'forms:components.rich-editor.toolbar.custom-blocks' => Tabler::Puzzle,
        'forms:components.rich-editor.toolbar.details' => Tabler::ListDetails,
        'forms:components.rich-editor.toolbar.grid' => Tabler::LayoutColumns,
        'forms:components.rich-editor.toolbar.grid_add_column_after' => Tabler::ColumnInsertRight,
        'forms:components.rich-editor.toolbar.grid_add_column_before' => Tabler::ColumnInsertLeft,
        'forms:components.rich-editor.toolbar.grid_delete' => Tabler::Trash,
        'forms:components.rich-editor.toolbar.grid_delete_column' => Tabler::ColumnRemove,
        'forms:components.rich-editor.toolbar.h1' => Tabler::H1,
        'forms:components.rich-editor.toolbar.h2' => Tabler::H2,
        'forms:components.rich-editor.toolbar.h3' => Tabler::H3,
        'forms:components.rich-editor.toolbar.h4' => Tabler::H4,
        'forms:components.rich-editor.toolbar.h5' => Tabler::H5,
        'forms:components.rich-editor.toolbar.h6' => Tabler::H6,
        'forms:components.rich-editor.toolbar.highlight' => Tabler::Highlight,
        'forms:components.rich-editor.toolbar.horizontal-rule' => Tabler::SeparatorHorizontal,
        'forms:components.rich-editor.toolbar.italic' => Tabler::Italic,
        'forms:components.rich-editor.toolbar.lead' => Tabler::TextSize,
        'forms:components.rich-editor.toolbar.link' => Tabler::Link,
        'forms:components.rich-editor.toolbar.merge-tags' => Tabler::Braces,
        'forms:components.rich-editor.toolbar.ordered-list' => Tabler::ListNumbers,
        'forms:components.rich-editor.toolbar.paragraph' => Tabler::Pilcrow,
        'forms:components.rich-editor.toolbar.redo' => Tabler::ArrowForwardUp,
        'forms:components.rich-editor.toolbar.small' => Tabler::TextDecrease,
        'forms:components.rich-editor.toolbar.strike' => Tabler::Strikethrough,
        'forms:components.rich-editor.toolbar.subscript' => Tabler::Subscript,
        'forms:components.rich-editor.toolbar.superscript' => Tabler::Superscript,
        'forms:components.rich-editor.toolbar.table' => Tabler::Table,
        'forms:components.rich-editor.toolbar.table_add_column_after' => Tabler::ColumnInsertRight,
        'forms:components.rich-editor.toolbar.table_add_column_before' => Tabler::ColumnInsertLeft,
        'forms:components.rich-editor.toolbar.table_add_row_after' => Tabler::RowInsertBottom,
        'forms:components.rich-editor.toolbar.table_add_row_before' => Tabler::RowInsertTop,
        'forms:components.rich-editor.toolbar.table_delete' => Tabler::Trash,
        'forms:components.rich-editor.toolbar.table_delete_column' => Tabler::ColumnRemove,
        'forms:components.rich-editor.toolbar.table_delete_row' => Tabler::RowRemove,
        'forms:components.rich-editor.toolbar.table_merge_cells' => Tabler::ArrowMerge,
        'forms:components.rich-editor.toolbar.table_split_cell' => Tabler::TableOptions,
        'forms:components.rich-editor.toolbar.table_toggle_header_cell' => Tabler::TableColumn,
        'forms:components.rich-editor.toolbar.table_toggle_header_row' => Tabler::TableRow,
        'forms:components.rich-editor.toolbar.text-color' => Tabler::TextColor,
        'forms:components.rich-editor.toolbar.underline' => Tabler::Underline,
        'forms:components.rich-editor.toolbar.undo' => Tabler::ArrowBackUp,

        // Infolists
        'infolists::components.icon-entry.false' => Tabler::CircleX,
        'infolists::components.icon-entry.true' => Tabler::CircleCheck,

        // Notifications
        'notifications::database.modal.empty-state' => Tabler::BellOff,
        'notifications::notification.close-button' => Tabler::X,
        'notifications::notification.danger' => Tabler::AlertTriangle,
        'notifications::notification.info' => Tabler::InfoCircle,
        'notifications::notification.success' => Tabler::CircleCheck,
        'notifications::notification.warning' => Tabler::AlertCircle,

        // Query builder (Filament 4.0 used the tables:: prefix for the constraints)
        'query-builder::add-rule-action' => Tabler::Plus,
        'query-builder::constraints.boolean' => Tabler::ToggleLeft,
        'query-builder::constraints.date' => Tabler::Calendar,
        'query-builder::constraints.number' => Tabler::Hash,
        'query-builder::constraints.relationship' => Tabler::Link,
        'query-builder::constraints.select' => Tabler::Selector,
        'query-builder::constraints.text' => Tabler::Typography,
        'query-builder::or-group.add-group-action' => Tabler::Plus,
        'query-builder::or-group.block' => Tabler::Stack2,
        'tables::filters.query-builder.constraints.boolean' => Tabler::ToggleLeft,
        'tables::filters.query-builder.constraints.date' => Tabler::Calendar,
        'tables::filters.query-builder.constraints.number' => Tabler::Hash,
        'tables::filters.query-builder.constraints.relationship' => Tabler::Link,
        'tables::filters.query-builder.constraints.select' => Tabler::Selector,
        'tables::filters.query-builder.constraints.text' => Tabler::Typography,

        // Schemas
        'schema::components.callout.danger' => Tabler::AlertTriangle,
        'schema::components.callout.info' => Tabler::InfoCircle,
        'schema::components.callout.success' => Tabler::CircleCheck,
        'schema::components.callout.warning' => Tabler::AlertCircle,
        'schema::components.tabs.dropdown-trigger-button' => Tabler::ChevronDown,
        'schema::components.tabs.more-tabs-button' => Tabler::Dots,
        'schema::components.wizard.completed-step' => Tabler::Check,

        // Support
        'badge.delete-button' => Tabler::X,
        'breadcrumbs.separator' => Tabler::ChevronRight,
        'breadcrumbs.separator.rtl' => Tabler::ChevronLeft,
        'modal.close-button' => Tabler::X,
        'pagination.first-button' => Tabler::ChevronsLeft,
        'pagination.first-button.rtl' => Tabler::ChevronsRight,
        'pagination.last-button' => Tabler::ChevronsRight,
        'pagination.last-button.rtl' => Tabler::ChevronsLeft,
        'pagination.next-button' => Tabler::ChevronRight,
        'pagination.next-button.rtl' => Tabler::ChevronLeft,
        'pagination.previous-button' => Tabler::ChevronLeft,
        'pagination.previous-button.rtl' => Tabler::ChevronRight,
        'section.collapse-button' => Tabler::ChevronUp,

        // Tables
        'tables::actions.column-manager' => Tabler::LayoutColumns,
        'tables::actions.disable-reordering' => Tabler::Check,
        'tables::actions.enable-reordering' => Tabler::ArrowsSort,
        'tables::actions.filter' => Tabler::Filter,
        'tables::actions.group' => Tabler::Stack2,
        'tables::actions.open-bulk-actions' => Tabler::DotsVertical,
        'tables::columns.collapse-button' => Tabler::ChevronDown,
        'tables::columns.icon-column.false' => Tabler::CircleX,
        'tables::columns.icon-column.true' => Tabler::CircleCheck,
        'tables::empty-state' => Tabler::X,
        'tables::filters.remove-all-button' => Tabler::X,
        'tables::grouping.collapse-button' => Tabler::ChevronUp,
        'tables::header-cell.sort-asc-button' => Tabler::ChevronUp,
        'tables::header-cell.sort-button' => Tabler::Selector,
        'tables::header-cell.sort-desc-button' => Tabler::ChevronDown,
        'tables::reorder.handle' => Tabler::GripVertical,
        'tables::search-field' => Tabler::Search,

        // Widgets
        'widgets::chart-widget.empty-state' => Tabler::ChartBar,
        'widgets::chart-widget.filter' => Tabler::Filter,
    ];
}
