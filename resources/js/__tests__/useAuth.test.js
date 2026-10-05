import { describe, it, expect, vi, beforeEach } from 'vitest';
import * as inertia from '@inertiajs/vue3';
import { useAuth } from '../Composables/useAuth.js';

vi.mock('@inertiajs/vue3', () => ({
    usePage: vi.fn(),
}));

describe('useAuth Composable', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('handles guest state correctly when user is null', () => {
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: null,
                },
            },
        });

        const { user, can, hasRole, isAtLeast, isGuest, isSuperAdmin, canAccessStudio } = useAuth();

        expect(user.value).toBeNull();
        expect(isGuest.value).toBe(true);
        expect(isSuperAdmin.value).toBe(false);
        expect(canAccessStudio.value).toBe(false);
        expect(can('access_studio')).toBe(false);
        expect(hasRole('guest', 'super_admin')).toBe(false);
        expect(isAtLeast(20)).toBe(false);
    });

    it('evaluates capabilities, weights, and roles correctly for an editor', () => {
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 5,
                        name: 'محرر الاستوديو',
                        email: 'editor@archive.org',
                        role: 'editor',
                        role_label: 'محرر الاستوديو والوسائط',
                        role_weight: 50,
                        badge_color: 'bg-teal-500/10 text-teal-400 border-teal-500/20',
                        is_active: true,
                        can: {
                            access_studio: true,
                            curate_metadata: true,
                            publish: false,
                            system_commands: false,
                            manage_backups: false,
                            view_audit_logs: false,
                            view_restricted: true,
                        },
                    },
                },
            },
        });

        const { user, can, hasRole, isAtLeast, isGuest, isSuperAdmin, canAccessStudio } = useAuth();

        expect(user.value).not.toBeNull();
        expect(user.value.name).toBe('محرر الاستوديو');
        expect(isGuest.value).toBe(false);
        expect(isSuperAdmin.value).toBe(false);
        expect(canAccessStudio.value).toBe(true);
        expect(can('access_studio')).toBe(true);
        expect(can('curate_metadata')).toBe(true);
        expect(can('publish')).toBe(false);
        expect(can('system_commands')).toBe(false);

        expect(hasRole('editor')).toBe(true);
        expect(hasRole('chief_editor', 'editor')).toBe(true);
        expect(hasRole('super_admin')).toBe(false);

        expect(isAtLeast(50)).toBe(true);
        expect(isAtLeast(30)).toBe(true);
        expect(isAtLeast(70)).toBe(false);
    });

    it('identifies super_admin sovereign permissions', () => {
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 1,
                        name: 'المدير العام',
                        role: 'super_admin',
                        role_weight: 100,
                        can: {
                            access_studio: true,
                            system_commands: true,
                            publish: true,
                            view_audit_logs: true,
                        },
                    },
                },
            },
        });

        const { isSuperAdmin, can, isAtLeast } = useAuth();

        expect(isSuperAdmin.value).toBe(true);
        expect(can('system_commands')).toBe(true);
        expect(can('publish')).toBe(true);
        expect(isAtLeast(100)).toBe(true);
    });
});
