import { writable } from 'svelte/store';

export type Locale = 'id' | 'en' | 'th' | 'tl';

export const locales: { id: Locale; label: string }[] = [
	{ id: 'id', label: 'Indonesia' },
	{ id: 'en', label: 'English' },
	{ id: 'th', label: 'ไทย' },
	{ id: 'tl', label: 'Tagalog' }
];

/** Bahasa aktif global. Persist di localStorage (dk-locale). */
export const locale = writable<Locale>('id');

export function initLocale() {
	try {
		const s = localStorage.getItem('dk-locale');
		if (s === 'id' || s === 'en' || s === 'th' || s === 'tl') locale.set(s);
	} catch {
		/* storage unavailable */
	}
	if (typeof document !== 'undefined') {
		locale.subscribe((l) => {
			document.documentElement.lang = l;
		});
	}
}

export function setLocale(l: Locale) {
	locale.set(l);
	try {
		localStorage.setItem('dk-locale', l);
	} catch {
		/* ignore */
	}
}

/**
 * Pola pemakaian di page (+page.svelte, runes):
 *
 *   import { locale } from '$lib/i18n';
 *   const STR = {
 *     id: { title: '...' },
 *     en: { title: '...' },
 *     th: { title: '...' },
 *     tl: { title: '...' }
 *   } as const;
 *   let s = $derived(STR[$locale]);
 *
 * lalu pakai {s.title}. Fallback: id bila key hilang.
 */
export function pick<K extends Record<string, string>>(strings: Record<Locale, K>, l: Locale): K {
	return strings[l] ?? strings.id;
}
