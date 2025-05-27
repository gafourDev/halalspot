import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

export default function UserDashboard() {
    return (
        <AppLayout>
            <Head title="User Dashboard" />
            <h1>Welcome, User!</h1>
            {/* User-specific content here */}
        </AppLayout>
    );
}