import { BellRing, Check, LockKeyhole, Volume2, type LucideIcon } from 'lucide-react';
import type { NotificationPreference } from '../types/notification';

type NotificationPreferencesProps = {
  preference?: NotificationPreference;
  saving: boolean;
  onChange: (payload: Pick<NotificationPreference, 'in_app_enabled' | 'reminder_enabled' | 'sound_enabled'>) => void;
};

export function NotificationPreferences({ preference, saving, onChange }: NotificationPreferencesProps) {
  const value = preference ?? {
    in_app_enabled: true,
    reminder_enabled: true,
    sound_enabled: true,
  };

  function update(key: 'in_app_enabled' | 'reminder_enabled' | 'sound_enabled', checked: boolean) {
    onChange({ ...value, [key]: checked });
  }

  return (
    <section aria-labelledby="notification-preference-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <BellRing aria-hidden="true" className="h-4 w-4 text-brand" />
        <h2 id="notification-preference-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Preferences</h2>
      </div>
      <div className="mt-4 space-y-3">
        <PreferenceToggle checked={value.in_app_enabled} description="Show notifications in the UtiFarm workspace." disabled={saving} icon={BellRing} label="In-App notification" onChange={(checked) => update('in_app_enabled', checked)} />
        <PreferenceToggle checked={value.reminder_enabled} description="Show operational reminder notifications." disabled={saving} icon={Check} label="Reminder" onChange={(checked) => update('reminder_enabled', checked)} />
        <PreferenceToggle checked={value.sound_enabled} description="Play a local alert sound for supported notifications." disabled={saving} icon={Volume2} label="Sound" onChange={(checked) => update('sound_enabled', checked)} />
      </div>
      <div className="mt-5 border-t border-slate-200 pt-4 dark:border-slate-800">
        <p className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Coming soon</p>
        <div className="mt-2 flex flex-wrap gap-2">
          {['Email', 'WhatsApp', 'Telegram', 'Push'].map((channel) => (
            <span className="inline-flex items-center gap-1 rounded-full border border-slate-200 px-2 py-1 text-xs text-slate-500 dark:border-slate-700 dark:text-slate-400" key={channel}>
              <LockKeyhole aria-hidden="true" className="h-3 w-3" />
              {channel}
            </span>
          ))}
        </div>
      </div>
    </section>
  );
}

function PreferenceToggle({ checked, description, disabled, icon: Icon, label, onChange }: { checked: boolean; description: string; disabled: boolean; icon: LucideIcon; label: string; onChange: (checked: boolean) => void }) {
  return (
    <label className="flex cursor-pointer items-start justify-between gap-3">
      <span className="flex gap-2">
        <Icon aria-hidden="true" className="mt-0.5 h-4 w-4 text-slate-500 dark:text-slate-400" />
        <span>
          <span className="block text-sm font-medium text-slate-700 dark:text-slate-200">{label}</span>
          <span className="block text-xs text-slate-500 dark:text-slate-400">{description}</span>
        </span>
      </span>
      <input aria-label={label} checked={checked} className="mt-1 h-4 w-4 rounded border-slate-300 text-brand focus:ring-brand" disabled={disabled} onChange={(event) => onChange(event.target.checked)} type="checkbox" />
    </label>
  );
}
