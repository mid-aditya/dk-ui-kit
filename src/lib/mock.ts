// Data mock untuk UI kit — ganti dengan fetch API saat integrasi backend.
export const agents = [
  { id: 'a1', name: 'Kirana Ayu', email: 'kirana@ahu.id', role: 'Agent', chats: 24, tickets: 11, csat: 4.8, status: 'online' },
  { id: 'a2', name: 'Bimo Prasetyo', email: 'bimo@ahu.id', role: 'Agent', chats: 19, tickets: 8, csat: 4.6, status: 'online' },
  { id: 'a3', name: 'Sinta Maharani', email: 'sinta@ahu.id', role: 'SPV', chats: 12, tickets: 15, csat: 4.9, status: 'busy' },
  { id: 'a4', name: 'Raka Aditya', email: 'raka@ahu.id', role: 'Agent', chats: 21, tickets: 6, csat: 4.4, status: 'offline' }
];

export const threads = [
  { id: 't1', customer: 'PT Maju Jaya', last: 'Paket saya belum sampai?', time: '2 mnt', channel: 'WhatsApp', status: 'open', unread: 3 },
  { id: 't2', customer: 'Sari Wulandari', last: 'Terima kasih banyak!', time: '18 mnt', channel: 'Email', status: 'pending', unread: 0 },
  { id: 't3', customer: 'CV Berkah Abadi', last: 'Minta invoice bulan ini', time: '1 jam', channel: 'WhatsApp', status: 'open', unread: 1 },
  { id: 't4', customer: 'Doni Saputra', last: 'Sudah resolved, thanks', time: '3 jam', channel: 'Telegram', status: 'resolved', unread: 0 }
];

export const tickets = [
  { id: 'k1', number: 'T-2026-001', subject: 'Keterlambatan pengiriman', customer: 'PT Maju Jaya', priority: 'urgent', status: 'open', sla: '2 jam', agent: 'Kirana Ayu' },
  { id: 'k2', number: 'T-2026-002', subject: 'Reset password akun', customer: 'Sari Wulandari', priority: 'medium', status: 'pending', sla: '6 jam', agent: 'Bimo Prasetyo' },
  { id: 'k3', number: 'T-2026-003', subject: 'Pengajuan refund', customer: 'CV Berkah Abadi', priority: 'low', status: 'resolved', sla: 'terpenuhi', agent: 'Sinta Maharani' }
];

export const emails = [
  { id: 'e1', from: 'cs@tokomaju.id', subject: 'Kerja sama layanan CS', date: '09:41', status: 'inbox', snippet: 'Halo tim, kami tertarik menggunakan layanan...' },
  { id: 'e2', from: 'noreply@ekspedisi.id', subject: 'Update resi pengiriman', date: '08:15', status: 'inbox', snippet: 'Paket dengan nomor resi ... telah sampai' },
  { id: 'e3', from: 'draf tersimpan', subject: 'Follow-up penawaran Q3', date: 'Kemarin', status: 'draft', snippet: 'Berikut penawaran yang kami janjikan...' },
  { id: 'e4', from: 'tim@ahu.id', subject: 'Jadwal shift minggu depan', date: 'Kemarin', status: 'send', snippet: 'Shift telah diterbitkan, silakan cek...' }
];

export const templates = [
  { id: 'tp1', name: 'Salam pembuka', subject: 'Halo {{nama}}, ada yang bisa kami bantu?' },
  { id: 'tp2', name: 'Follow-up tiket', subject: 'Update tiket {{nomor}}: {{status}}' },
  { id: 'tp3', name: 'Survei CSAT', subject: 'Seberapa puas Anda dengan layanan kami?' }
];

export const recordings = [
  { id: 'r1', agent: 'Kirana Ayu', customer: 'PT Maju Jaya', duration: '04:32', date: 'Hari ini 10:20', score: 92 },
  { id: 'r2', agent: 'Bimo Prasetyo', customer: 'Sari Wulandari', duration: '02:15', date: 'Hari ini 09:05', score: 85 },
  { id: 'r3', agent: 'Raka Aditya', customer: 'CV Berkah Abadi', duration: '07:48', date: 'Kemarin 16:40', score: 78 }
];

export const csat = [
  { label: 'Sangat puas', pct: 68 },
  { label: 'Puas', pct: 21 },
  { label: 'Netral', pct: 7 },
  { label: 'Tidak puas', pct: 4 }
];

export const schedule = [
  { day: 'Senin', shift: 'Pagi (08–16)', agents: 12 },
  { day: 'Selasa', shift: 'Pagi (08–16)', agents: 12 },
  { day: 'Rabu', shift: 'Siang (13–21)', agents: 10 },
  { day: 'Kamis', shift: 'Siang (13–21)', agents: 10 },
  { day: "Jumat", shift: 'Pagi (08–16)', agents: 8 }
];
