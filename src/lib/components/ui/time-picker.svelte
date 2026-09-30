<script lang="ts">
	import * as Select from "$lib/components/ui/select";
	import ClockIcon from "@lucide/svelte/icons/clock";
	import { cn } from "$lib/utils";

	let {
		value = $bindable("08:00"),
		label = "Pilih jam",
		class: className
	}: {
		value?: string;
		label?: string;
		class?: string;
	} = $props();

	const hours = Array.from({ length: 24 }, (_, i) => String(i).padStart(2, "0"));
	const minutes = Array.from({ length: 12 }, (_, i) => String(i * 5).padStart(2, "0"));

	const fallbackHour = "08";
	const fallbackMinute = "00";

	function parse(v: string | undefined): [string, string] {
		const parts = (v ?? "").split(":");
		const h = parts[0] && hours.includes(parts[0]) ? parts[0] : fallbackHour;
		const m = parts[1] && minutes.includes(parts[1]) ? parts[1] : fallbackMinute;
		return [h, m];
	}

	const initial = parse(value);
	let hour = $state(initial[0]);
	let minute = $state(initial[1]);

	// Sinkronisasi dari luar (mis. dialog edit dibuka ulang dengan nilai lain).
	$effect(() => {
		const [h, m] = parse(value);
		if (h !== hour) hour = h;
		if (m !== minute) minute = m;
	});

	// Propagasi ke luar sebagai "HH:MM".
	$effect(() => {
		const next = `${hour}:${minute}`;
		if (value !== next) value = next;
	});
</script>

<div class={cn("flex flex-col gap-1.5", className)}>
	<span class="text-sm leading-none font-medium">{label}</span>
	<div class="flex items-center gap-2">
		<ClockIcon data-icon="inline-start" />
		<Select.Root type="single" bind:value={hour}>
			<Select.Trigger aria-label="{label} — jam" class="flex-1 tabular-nums">{hour}</Select.Trigger>
			<Select.Content>
				<Select.Group>
					<Select.GroupHeading>Jam</Select.GroupHeading>
					{#each hours as h}
						<Select.Item value={h}>{h}</Select.Item>
					{/each}
				</Select.Group>
			</Select.Content>
		</Select.Root>
		<span aria-hidden="true" class="text-muted-foreground font-medium">:</span>
		<Select.Root type="single" bind:value={minute}>
			<Select.Trigger aria-label="{label} — menit" class="flex-1 tabular-nums">{minute}</Select.Trigger>
			<Select.Content>
				<Select.Group>
					<Select.GroupHeading>Menit</Select.GroupHeading>
					{#each minutes as m}
						<Select.Item value={m}>{m}</Select.Item>
					{/each}
				</Select.Group>
			</Select.Content>
		</Select.Root>
	</div>
</div>
