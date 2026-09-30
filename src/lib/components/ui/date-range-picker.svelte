<script lang="ts">
	import * as Popover from "$lib/components/ui/popover";
	import { RangeCalendar } from "$lib/components/ui/range-calendar";
	import { Button } from "$lib/components/ui/button";
	import { cn } from "$lib/utils";
	import CalendarIcon from "@lucide/svelte/icons/calendar";
	import type { DateRange } from "bits-ui";

	let {
		value = $bindable(undefined),
		label = "Pilih periode",
		placeholder = "Pilih periode",
		class: className
	}: {
		value?: DateRange | undefined;
		label?: string;
		placeholder?: string;
		class?: string;
	} = $props();
</script>

<Popover.Root>
	<Popover.Trigger aria-label={label}>
		{#snippet child({ props })}
			<Button {...props} variant="outline" class={cn("w-full justify-start font-normal", className)}>
				<CalendarIcon data-icon="inline-start" />
				{#if value?.start}
					{value.start.toString()}{#if value.end} - {value.end.toString()}{/if}
				{:else}
					<span class="text-muted-foreground">{placeholder}</span>
				{/if}
			</Button>
		{/snippet}
	</Popover.Trigger>
	<Popover.Content align="start" class="w-auto p-0">
		<Popover.Title class="sr-only">{label}</Popover.Title>
		<Popover.Description class="sr-only">Kalender pemilih rentang tanggal.</Popover.Description>
		<RangeCalendar bind:value numberOfMonths={1} locale="id-ID" />
	</Popover.Content>
</Popover.Root>
