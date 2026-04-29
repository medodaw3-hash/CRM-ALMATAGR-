{{-- resources/views/components/countdown.blade.php
     Renders a date as a localized human countdown.

     EN: "In 2 days" / "Overdue 1d" / "5h ago"
     AR: "خلال يومين"  / "متأخر بـ 1 يوم" / "منذ 5 ساعات"

     Usage:
        <x-countdown :date="$lead->next_followup_at" />
        <x-countdown :date="$lead->last_contact_at" past />
--}}
@props([
    'date' => null,
    'past' => false,
    'fallback' => '—',
])

@php
    $isAr = app()->getLocale() === 'ar';

    if (!$date) {
        $text = $fallback;
        $color = 'text-ink-400';
    } else {
        $dt = $date instanceof \DateTimeInterface
              ? \Carbon\Carbon::instance($date)
              : \Carbon\Carbon::parse($date);

        // Use Carbon's localized diffForHumans when possible (fully translated)
        $dt->locale(app()->getLocale());
        $now = \Carbon\Carbon::now();
        $diffMinutes = $now->diffInMinutes($dt, false);

        if ($past) {
            // "5 hours ago" / "منذ 5 ساعات"
            $text = $dt->diffForHumans(['parts' => 1]);
            $color = 'text-ink-600';
        } else {
            if ($diffMinutes < 0) {
                $absHours = ceil(abs($diffMinutes) / 60);
                $absDays  = ceil(abs($diffMinutes) / (60*24));

                if ($absHours < 24) {
                    $text = $isAr
                        ? 'متأخر بـ ' . $absHours . ' ساعة'
                        : 'Overdue ' . $absHours . 'h';
                } else {
                    $text = $isAr
                        ? 'متأخر بـ ' . $absDays . ' يوم'
                        : 'Overdue ' . $absDays . 'd';
                }
                $color = 'text-rose-600 font-medium';
            } elseif ($diffMinutes < 60) {
                $mins = max(1, round($diffMinutes));
                $text = $isAr ? 'خلال ' . $mins . ' دقيقة' : 'In ' . $mins . 'm';
                $color = 'text-amber-700 font-medium';
            } elseif ($diffMinutes < 60 * 24) {
                $hours = round($diffMinutes / 60);
                $text = $isAr ? 'خلال ' . $hours . ' ساعة' : 'In ' . $hours . 'h';
                $color = 'text-amber-700 font-medium';
            } elseif ($diffMinutes < 60 * 24 * 2) {
                $text = $isAr ? 'غداً' : 'Tomorrow';
                $color = 'text-ink-700';
            } elseif ($diffMinutes < 60 * 24 * 7) {
                $days = round($diffMinutes / (60*24));
                $text = $isAr ? 'خلال ' . $days . ' أيام' : 'In ' . $days . ' days';
                $color = 'text-ink-700';
            } else {
                // Localized month names via Carbon
                $text = $dt->translatedFormat('j M');
                $color = 'text-ink-500';
            }
        }
    }
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1 text-xs', $color]) }}
      title="{{ $date ? \Carbon\Carbon::parse($date)->locale(app()->getLocale())->translatedFormat('j M Y, g:i A') : '' }}">
    {{ $text }}
</span>
