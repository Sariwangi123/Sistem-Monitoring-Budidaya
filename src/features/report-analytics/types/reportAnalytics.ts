export type ReportCategoryKey =
  | 'executive'
  | 'operational'
  | 'production'
  | 'inventory'
  | 'harvest'
  | 'financial'
  | 'kpi'
  | 'audit';

export type ReportFilters = {
  company_id?: string;
  farm_id?: string;
  pond_id?: string;
  culture_cycle_id?: string;
  financial_period_id?: string;
  customer_id?: string;
  report_category?: string;
  date_range?: string;
  period?: string;
  search?: string;
};

export type ReportDefinition = {
  id: string;
  name: string;
  category: ReportCategoryKey | string;
  source_module: string;
  template: string;
  required_permission: string | null;
  supported_export_formats: Array<'pdf' | 'xlsx' | 'csv' | 'json' | string>;
  schedule_support: boolean;
  version: string;
  allowed_roles: string[];
};

export type ReportRegistryResponse = {
  items: ReportDefinition[];
};

export type ReportRegistryDetailResponse = {
  item: ReportDefinition;
};

export type ReportCategoryResponse = {
  category: string;
  reports: ReportDefinition[];
  filters: ReportFilters;
  summary: {
    status: string;
    read_only: boolean;
    source_strategy: string;
  };
  sections: ReportPreviewSection[];
};

export type ReportPreviewSection = {
  key: string;
  title: string;
  status: string;
  items: unknown[];
};

export type ReportGeneratePayload = {
  report_type: string;
  template?: string;
  export_format: 'pdf' | 'xlsx' | 'csv' | 'json';
  locale?: 'id' | 'en';
  filter?: ReportFilters;
  parameter?: Record<string, unknown>;
};

export type ReportGeneratedResponse = {
  definition: ReportDefinition;
  template: {
    key: string;
    title: string;
    sections: string[];
    layout: Record<string, string>;
    format: Record<string, unknown>;
  };
  export: {
    file_name: string;
    format: string;
    status: string;
    production_file_export: boolean;
    payload: {
      rendering: string;
      read_only: boolean;
      build: {
        sections: Array<{
          key: string;
          title: string;
          data: Record<string, unknown>;
        }>;
      };
    };
  };
  meta: {
    read_only: boolean;
    generate_never_store: boolean;
    engine: string;
  };
};

export type ReportExportMetadata = {
  report: ReportDefinition;
  format: string;
  adapter: string;
  production_file_export: boolean;
  supported_export_formats: string[];
};

export type ReportScheduleItem = {
  uuid: string;
  report?: ReportDefinition;
  frequency: string;
  export_format: string;
  timezone: string;
  filters: ReportFilters;
  status: string;
  production_scheduler: boolean;
};

export type ReportSchedulesResponse = {
  items: ReportScheduleItem[];
  foundation: {
    schedule_support: string;
    production_scheduler: boolean;
    queue_job: boolean;
  };
};

export type ReportSchedulePayload = {
  report_id: string;
  frequency: 'daily' | 'weekly' | 'monthly' | 'quarterly' | 'yearly';
  export_format: 'pdf' | 'xlsx' | 'csv' | 'json';
  timezone?: string;
  filters?: ReportFilters;
};

export type ReportScheduleDeleteResponse = {
  uuid: string;
  deleted: boolean;
  production_scheduler: boolean;
};
