<script lang="ts">
  import { cn } from '$lib/utils';
  import { ChevronLeft, ChevronRight } from 'lucide-svelte';

  type Props = {
    class?: string;
    value?: Date | null;
    onValueChange?: (date: Date | null) => void;
    minDate?: Date;
    maxDate?: Date;
    disabled?: boolean;
  };

  let { class: className = '', value = null, onValueChange, minDate, maxDate, disabled = false }: Props = $props();

  let currentMonth = $state(value?.getMonth() ?? new Date().getMonth());
  let currentYear = $state(value?.getFullYear() ?? new Date().getFullYear());

  const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
  ];

  function getDaysInMonth(year: number, month: number): number {
    return new Date(year, month + 1, 0).getDate();
  }

  function getFirstDayOfMonth(year: number, month: number): number {
    return new Date(year, month, 1).getDay();
  }

  function prevMonth() {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear--;
    } else {
      currentMonth--;
    }
  }

  function nextMonth() {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear++;
    } else {
      currentMonth++;
    }
  }

  function selectDate(day: number) {
    if (disabled) return;
    const newDate = new Date(currentYear, currentMonth, day);
    
    // Check min/max dates
    if (minDate && newDate < minDate) return;
    if (maxDate && newDate > maxDate) return;
    
    value = newDate;
    onValueChange?.(newDate);
  }

  function isSelected(day: number): boolean {
    if (!value) return false;
    return (
      value.getDate() === day &&
      value.getMonth() === currentMonth &&
      value.getFullYear() === currentYear
    );
  }

  function isToday(day: number): boolean {
    const today = new Date();
    return (
      today.getDate() === day &&
      today.getMonth() === currentMonth &&
      today.getFullYear() === currentYear
    );
  }

  function isDisabled(day: number): boolean {
    if (disabled) return true;
    const date = new Date(currentYear, currentMonth, day);
    if (minDate && date < minDate) return true;
    if (maxDate && date > maxDate) return true;
    return false;
  }

  function isOutsideMonth(day: number): boolean {
    const firstDay = getFirstDayOfMonth(currentYear, currentMonth);
    const daysInMonth = getDaysInMonth(currentYear, currentMonth);
    
    // Check if day is from previous month
    if (day <= firstDay) return true;
    // Check if day is from next month
    if (day > daysInMonth) return true;
    return false;
  }

  let days = $derived.by(() => {
    const firstDay = getFirstDayOfMonth(currentYear, currentMonth);
    const daysInMonth = getDaysInMonth(currentYear, currentMonth);
    const daysInPrevMonth = getDaysInMonth(currentYear, currentMonth - 1);
    
    const result: { day: number; month: 'prev' | 'current' | 'next' }[] = [];
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
      result.push({ day: daysInPrevMonth - i, month: 'prev' });
    }
    
    // Current month days
    for (let i = 1; i <= daysInMonth; i++) {
      result.push({ day: i, month: 'current' });
    }
    
    // Next month days (fill to 42 cells = 6 rows)
    const remaining = 42 - result.length;
    for (let i = 1; i <= remaining; i++) {
      result.push({ day: i, month: 'next' });
    }
    
    return result;
  });
</script>

<div class={cn('w-full max-w-sm rounded-lg border bg-card p-3 shadow-sm', className)}>
  <!-- Header -->
  <div class="flex items-center justify-between pb-3">
    <button
      type="button"
      onclick={prevMonth}
      class="rounded-md p-1.5 hover:bg-accent"
      aria-label="Previous month"
    >
      <ChevronLeft size={16} />
    </button>
    <span class="text-sm font-semibold">
      {months[currentMonth]} {currentYear}
    </span>
    <button
      type="button"
      onclick={nextMonth}
      class="rounded-md p-1.5 hover:bg-accent"
      aria-label="Next month"
    >
      <ChevronRight size={16} />
    </button>
  </div>

  <!-- Weekdays -->
  <div class="grid grid-cols-7 gap-1">
    {#each weekdays as day}
      <div class="pb-2 text-center text-xs font-medium text-muted-foreground">
        {day}
      </div>
    {/each}
  </div>

  <!-- Days -->
  <div class="grid grid-cols-7 gap-1">
    {#each days as { day, month }}
      <button
        type="button"
        onclick={() => selectDate(day)}
        disabled={isDisabled(day)}
        class={cn(
          'aspect-square rounded-md text-sm transition-colors',
          month !== 'current' && 'text-muted-foreground/50',
          isSelected(day) && 'bg-primary text-primary-foreground hover:bg-primary',
          isToday(day) && !isSelected(day) && 'bg-accent',
          !isSelected(day) && !isToday(day) && 'hover:bg-accent',
          isDisabled(day) && 'pointer-events-none opacity-30'
        )}
      >
        {day}
      </button>
    {/each}
  </div>
</div>
