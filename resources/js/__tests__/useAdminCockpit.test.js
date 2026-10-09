import { describe, it, expect, vi, beforeEach } from 'vitest';
import { useAdminCockpit, viewCatalog } from '../Composables/useAdminCockpit.js';

describe('useAdminCockpit Composable (Cycle 30 TDD)', () => {
  const mockProps = {
    stats: { books: 150, manuscripts: 40, authors: 20 },
    books: [{ id: 1, title: 'كتاب الفقه' }],
    manuscripts: [{ id: 10, title: 'مخطوطة النحو' }],
    audios: [{ id: 20, title: 'شرح صوتي' }],
    videos: [{ id: 30, title: 'محاضرة مرئية' }],
    authors: [{ id: 40, name: 'ابن خلدون' }],
    publishers: [{ id: 50, name: 'دار المعارف' }],
    studioBooks: [{ id: 60, title: 'كتاب الاستوديو' }],
    versions: [{ id: 70, label: 'v1.0' }],
    collections: [{ id: 80, name: 'المجموعة الأولى' }],
    series: [{ id: 90, title: 'السلسلة الكاملة' }],
    topics: [{ id: 100, name: 'أصول الفقه' }],
    tags: [{ id: 110, name: 'نادر' }],
    categories: [{ id: 120, name: 'علوم شرعية' }],
  };

  beforeEach(() => {
    vi.clearAllMocks();
    document.body.innerHTML = `
      <div id="dynamicContentArea"></div>
      <div id="breadcrumbGroup"></div>
      <div id="breadcrumbCurrent"></div>
      <button id="themeToggleBtn"></button>
      <div id="themeIconSun"></div>
      <div id="themeIconMoon"></div>
      <div id="userDropdownMenu" style="display: none;"></div>
      <div class="user-menu-wrapper"></div>
    `;
    window.location.hash = '';
    window.scrollTo = vi.fn();
    localStorage.clear();
  });

  it('exposes viewCatalog with correct groups and Arabic labels', () => {
    expect(viewCatalog.books).toEqual({ title: 'الكتب', group: 'المكتبة' });
    expect(viewCatalog.stats).toEqual({ title: 'الإحصائيات', group: 'النظام' });
    expect(viewCatalog.authors).toEqual({ title: 'المؤلفون', group: 'الأشخاص' });
    expect(viewCatalog['studio-books']).toEqual({ title: 'الكتب', group: 'الاستوديو' });
    expect(viewCatalog.collections).toEqual({ title: 'المجموعات', group: 'التنظيم' });
  });

  it('initializes with default stats view and reactive title computations', () => {
    const cockpit = useAdminCockpit(mockProps);

    expect(cockpit.currentViewKey.value).toBe('stats');
    expect(cockpit.currentGroupTitle.value).toBe('النظام');
    expect(cockpit.currentViewTitle.value).toBe('الإحصائيات');
  });

  it('loads a specific view, updates hash and breadcrumbs reactively', async () => {
    const cockpit = useAdminCockpit(mockProps);

    cockpit.loadView('books');
    expect(cockpit.currentViewKey.value).toBe('books');
    expect(cockpit.currentGroupTitle.value).toBe('المكتبة');
    expect(cockpit.currentViewTitle.value).toBe('الكتب');

    const groupEl = document.getElementById('breadcrumbGroup');
    const currentEl = document.getElementById('breadcrumbCurrent');
    expect(groupEl.textContent).toBe('المكتبة');
    expect(currentEl.textContent).toBe('الكتب');
  });

  it('resolves sector item getters accurately from props with fallbacks', () => {
    const cockpit = useAdminCockpit(mockProps);

    expect(cockpit.getLibraryItems('books')).toEqual(mockProps.books);
    expect(cockpit.getLibraryItems('manuscripts')).toEqual(mockProps.manuscripts);
    expect(cockpit.getLibraryItems('audios')).toEqual(mockProps.audios);
    expect(cockpit.getLibraryItems('videos')).toEqual(mockProps.videos);
    expect(cockpit.getLibraryItems('unknown')).toEqual([]);

    expect(cockpit.getPeopleItems('authors')).toEqual(mockProps.authors);
    expect(cockpit.getPeopleItems('publishers')).toEqual(mockProps.publishers);

    expect(cockpit.getStudioItems('studio-books')).toEqual(mockProps.studioBooks);
    expect(cockpit.getStudioItems('versions')).toEqual(mockProps.versions);

    expect(cockpit.getTaxonomyItems('collections')).toEqual(mockProps.collections);
    expect(cockpit.getTaxonomyItems('series')).toEqual(mockProps.series);
    expect(cockpit.getTaxonomyItems('topics')).toEqual(mockProps.topics);
    expect(cockpit.getTaxonomyItems('tags')).toEqual(mockProps.tags);
    expect(cockpit.getTaxonomyItems('categories')).toEqual(mockProps.categories);
  });

  it('handles theme toggling and persists to localStorage', () => {
    const cockpit = useAdminCockpit(mockProps);

    cockpit.setTheme(false); // Switch to Light
    expect(cockpit.isDarkMode.value).toBe(false);
    expect(localStorage.getItem('theme')).toBe('light');
    expect(document.body.classList.contains('light-mode')).toBe(true);

    cockpit.toggleTheme(); // Switch to Dark
    expect(cockpit.isDarkMode.value).toBe(true);
    expect(localStorage.getItem('theme')).toBe('dark');
    expect(document.body.classList.contains('light-mode')).toBe(false);
  });

  it('toggles user dropdown display reactively', () => {
    const cockpit = useAdminCockpit(mockProps);
    const menu = document.getElementById('userDropdownMenu');

    cockpit.toggleUserDropdown();
    expect(menu.style.display).toBe('block');

    cockpit.toggleUserDropdown();
    expect(menu.style.display).toBe('none');
  });
});
