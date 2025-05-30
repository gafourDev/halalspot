import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

export default function OwnerDashboard() {
    return (
        <AppLayout>
            <Head title="User Dashboard" />
            <h1>Welcome, Owner!</h1>
            {/* User-specific content here */}
        </AppLayout>
    );
}
