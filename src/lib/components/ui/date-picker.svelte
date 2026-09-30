<script lang="ts">
	import * as Popover from "$lib/components/ui/popover";
	import { Calendar } from "$lib/components/ui/calendar";
	import { Button } from "$lib/components/ui/button";
	import { cn } from "$lib/utils";
	import CalendarIcon from "@lucide/svelte/icons/calendar";
	import type { DateValue } from "@internationalized/date";

	let {
		value = $bindable(undefined),
		label = "Pilih tanggal",
		placeholder = "Pilih tanggal",
		class: className
	}: {
		value?: DateValue | undefined;
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
				{#if value}
					{value.toString()}
				{:else}
					<span class="text-muted-foreground">{placeholder}</span>
				{/if}
			</Button>
		{/snippet}
	</Popover.Trigger>
	<Popover.Content align="start" class="w-auto p-0">
		<Popover.Title class="sr-only">{label}</Popover.Title>
		<Popover.Description class="sr-only">Kalender pemilih tanggal.</Popover.Description>
		<Calendar type="single" bind:value />
	</Popover.Content>
</Popover.Root>
