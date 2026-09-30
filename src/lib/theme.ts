import { writable } from 'svelte/store';

function initial(): boolean {
  try {
    const saved = localStorage.getItem('dk-theme');
    if (saved) return saved === 'dark';
    return window.matchMedia?.('(prefers-color-scheme: dark)').matches ?? false;
  } catch {
    return false;
  }
}

function apply(dark: boolean) {
  document.documentElement.classList.toggle('dark', dark);
  try {
    localStorage.setItem('dk-theme', dark ? 'dark' : 'light');
  } catch { /* abaikan */ }
}

export const darkMode = writable(false);

export function initTheme() {
  const dark = initial();
  apply(dark);
  darkMode.set(dark);
}

export function toggleTheme() {
  darkMode.update((d) => {
    apply(!d);
    return !d;
  });
}
