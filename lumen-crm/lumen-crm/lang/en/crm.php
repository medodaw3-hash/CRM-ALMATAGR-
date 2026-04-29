<?php
// lang/en/crm.php
//
// Master English strings. The Arabic file mirrors the same keys.
// Usage in Blade: {{ __('crm.leads.title') }} or @lang('crm.dashboard.greeting_morning')

return [

    /* ----------------------------------------
     | Brand & layout
     ---------------------------------------- */
    'app' => [
        'name'      => 'Lumen',
        'tagline'   => 'Sales CRM',
    ],

    /* ----------------------------------------
     | Sidebar navigation
     ---------------------------------------- */
    'nav' => [
        'workspace'   => 'Workspace',
        'account'     => 'Account',
        'dashboard'   => 'Dashboard',
        'leads'       => 'Leads',
        'followups'   => 'Follow-ups',
        'clients'     => 'Clients',
        'reports'     => 'Reports',
        'settings'    => 'Settings',
        'sales_workspace' => 'Sales workspace',
        'sign_out'    => 'Sign out',
    ],

    /* ----------------------------------------
     | Topbar / global
     ---------------------------------------- */
    'topbar' => [
        'search_placeholder' => 'Search leads, clients, reports…',
        'notifications'      => 'Notifications',
        'new_lead'           => 'New lead',
    ],

    /* ----------------------------------------
     | Status labels (single source of truth)
     ---------------------------------------- */
    'status' => [
        'new'        => 'New',
        'followup'   => 'Follow-up',
        'interested' => 'Interested',
        'converted'  => 'Converted',
        'rejected'   => 'Rejected',
        'active'     => 'Active',
        'atrisk'     => 'At risk',
        'churned'    => 'Churned',
        'hot'        => 'Hot',
        'won'        => 'Won',
        'lost'       => 'Lost',
        'done'       => 'Done',
    ],

    /* ----------------------------------------
     | Dashboard
     ---------------------------------------- */
    'dashboard' => [
        'greeting_morning'   => 'Good morning, :name',
        'greeting_afternoon' => 'Good afternoon, :name',
        'greeting_evening'   => 'Good evening, :name',
        'subtitle'           => "Here's what's happening across your pipeline today.",
        'kpi_leads_today'    => 'Leads today',
        'kpi_followups_today'=> 'Follow-ups today',
        'kpi_converted'      => 'Converted leads',
        'kpi_rejected'       => 'Rejected leads',
        'overdue_count'      => ':count overdue',
        'done_progress'      => ':done/:total done',
        'total_value'        => 'total value',
        'top_reason'         => 'Top reason: :reason',
        'conversion_rate'    => 'Conversion rate',
        'conversion_subtitle'=> 'Leads converted across the last 12 weeks',
        'this_period'        => 'This period',
        'previous'           => 'Previous',
        'rejection_reasons'  => 'Rejection reasons',
        'rejection_subtitle' => "Why deals didn't close",
        'recent_activity'    => 'Recent activity',
        'view_all'           => 'View all',
        'pipeline'           => 'Pipeline',
        'leads_count'        => ':count leads',
    ],

    /* ----------------------------------------
     | Leads
     ---------------------------------------- */
    'leads' => [
        'title'           => 'Leads',
        'subtitle'        => ':total leads in pipeline · :closed closed this month',
        'export'          => 'Export',
        'kanban'          => 'Kanban',
        'table'           => 'Table',
        'filter'          => 'Filter',
        'sort_by'         => 'Sort: :field',
        'sort_last_contact' => 'Last contact',
        'agent'           => 'Agent: :name',
        'agent_all'       => 'All',
        'search'          => 'Search leads',
        'add_lead'        => 'Add lead',
        'no_results'      => 'No leads match your filters.',
        'unassigned'      => 'Unassigned',

        // Table headers
        'col_store'       => 'Store',
        'col_phone'       => 'Phone',
        'col_status'      => 'Status',
        'col_last_contact'=> 'Last contact',
        'col_next_followup' => 'Next follow-up',
        'col_agent'       => 'Agent',

        // Lead card
        'last'            => 'Last',
        'no_followup'     => 'No follow-up',

        // Detail page
        'breadcrumb'      => 'Leads',
        'mark_contacted'  => 'Mark contacted',
        'schedule_followup' => 'Schedule follow-up',
        'convert_to_client' => 'Convert to client',
        'reject'          => 'Reject',
        'created_on'      => '#L-:id · created :date',
        'contact_info'    => 'Contact info',
        'owner'           => 'Owner',
        'phone'           => 'Phone',
        'email'           => 'Email',
        'city'            => 'City',
        'branches'        => 'Branches',
        'deal_value'      => 'Deal value',
        'assignment'      => 'Assignment',
        'reassign'        => 'Reassign',
        'assign_agent'    => 'Assign agent',
        'tags'            => 'Tags',
        'add_tag'         => 'Add',
        'activity'        => 'Activity',
        'all'             => 'All',
        'calls'           => 'Calls',
        'notes'           => 'Notes',
        'newest_first'    => 'Newest first',
        'composer_note'   => 'Note',
        'composer_call'   => 'Call',
        'composer_email'  => 'Email',
        'composer_schedule' => 'Schedule',
        'composer_placeholder' => 'Add a note about this lead…',
        'post'            => 'Post',
        'lead_created'    => 'Lead created',
        'imported_via'    => 'Imported via :source.',
        'imported'        => 'Imported.',
    ],

    /* ----------------------------------------
     | Follow-ups
     ---------------------------------------- */
    'followups' => [
        'title'           => 'Follow-ups',
        'today_label'     => 'Today, :date',
        'hero_count'      => 'You have :count :leads to follow today',
        'lead_singular'   => 'lead',
        'lead_plural'     => 'leads',
        'hero_message_overdue' => 'Stay on rhythm. :count overdue — handle those first to keep deals warm.',
        'hero_message_clear'   => "Stay on rhythm. You're all caught up — great work.",
        'start_overdue'   => 'Start with overdue',
        'view_calendar'   => 'View calendar',
        'tab_overdue'     => 'Overdue',
        'tab_today'       => 'Today',
        'tab_tomorrow'    => 'Tomorrow',
        'tab_week'        => 'This week',
        'tab_completed'   => 'Completed',
        'completed_at'    => 'Completed at :time',
        'scheduled_at'    => ':note · scheduled :time',
        'no_note'         => 'No note',
        'call'            => 'Call',
        'reschedule'      => 'Reschedule',
        'empty_title'     => 'No follow-ups in this view',
        'empty_subtitle'  => "You're all caught up.",
    ],

    /* ----------------------------------------
     | Clients
     ---------------------------------------- */
    'clients' => [
        'title'         => 'Clients',
        'subtitle'      => ':active active · :churned churned this quarter',
        'export_csv'    => 'Export CSV',
        'add_client'    => 'Add client',
        'search'        => 'Search clients',
        'all_status'    => 'All status',
        'all_cities'    => 'All cities',
        'all_plans'     => 'All plans',
        'col_client'    => 'Client',
        'col_status'    => 'Status',
        'col_plan'      => 'Plan',
        'col_mrr'       => 'MRR',
        'col_owner'     => 'Owner',
        'col_since'     => 'Since',
        'view'          => 'View',
        'unassigned'    => 'Unassigned',
        'no_clients'    => 'No clients yet.',
        'plan_starter'    => 'Starter',
        'plan_growth'     => 'Growth',
        'plan_enterprise' => 'Enterprise',
    ],

    /* ----------------------------------------
     | Reports
     ---------------------------------------- */
    'reports' => [
        'title'             => 'Reports',
        'subtitle'          => 'Performance overview · :range',
        'range_7d'          => 'Last 7 days',
        'range_30d'         => 'Last 30 days',
        'range_90d'         => 'Last 90 days',
        'range_ytd'         => 'Year to date',
        'export_pdf'        => 'Export PDF',
        'conversion_rate'   => 'Conversion rate',
        'lead_to_client'    => 'Lead → Client',
        'vs_prev'           => 'vs prev',
        'leads_per_agent'   => 'Leads per agent',
        'leads_per_agent_subtitle' => 'Closed leads in selected period',
        'sales_funnel'      => 'Sales funnel',
        'sales_funnel_subtitle'    => 'From new lead to closed deal',
        'rejection_reasons' => 'Rejection reasons',
        'lost_deals'        => ':count lost deals',
        'top_reason'        => 'top reason',
        'funnel_new'        => 'New leads',
        'funnel_contacted'  => 'Contacted',
        'funnel_interested' => 'Interested',
        'funnel_converted'  => 'Converted',
    ],

    /* ----------------------------------------
     | Common UI
     ---------------------------------------- */
    'common' => [
        'cancel'    => 'Cancel',
        'save'      => 'Save',
        'edit'      => 'Edit',
        'delete'    => 'Delete',
        'close'     => 'Close',
        'previous'  => 'Previous',
        'next'      => 'Next',
        'showing'   => 'Showing :from–:to of :total',
        'when'      => 'When',
        'note'      => 'Note',
        'reason'    => 'Reason',
        'select_reason' => 'Select a reason…',
        'optional'  => 'optional',
        'loading'   => 'Loading…',
        'language'  => 'Language',
    ],

    /* ----------------------------------------
     | Countdown helper
     ---------------------------------------- */
    'countdown' => [
        'just_now'   => 'just now',
        'min_ago'    => ':n m ago',
        'hour_ago'   => ':n h ago',
        'day_ago'    => ':n d ago',
        'in_min'     => 'In :n m',
        'in_hour'    => 'In :n h',
        'in_day'     => 'In :n day|In :n days',
        'tomorrow'   => 'Tomorrow',
        'today'      => 'Today',
        'overdue_h'  => 'Overdue :n h',
        'overdue_d'  => 'Overdue :n d',
        'no_date'    => '—',
    ],

    /* ----------------------------------------
     | Rejection reasons (used in modal + reports)
     ---------------------------------------- */
    'rejection_reasons' => [
        'price'       => 'Price too high',
        'budget'      => 'No budget',
        'competitor'  => 'Chose competitor',
        'timing'      => 'Bad timing',
        'other'       => 'Other',
    ],
];
