import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

export default function AdminDashboard() {
    return (
        <AppLayout>
            <Head title="Admin Dashboard" />
            <h1>Welcome, Admin!</h1>
            {/* Admin-specific content here */}
        </AppLayout>
    );
}