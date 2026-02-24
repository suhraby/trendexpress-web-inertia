<template>
    <Head title="Dashboard" />

    <div
        class="relative"
        :class="activePanel ? 'h-screen overflow-hidden' : ''"
    >
        <div
            @click="closeAllModal"
            :class="[
                'bg-charcoal/25 absolute top-0 left-0 z-10 block h-screen w-full',
                activePanel ? 'block' : 'hidden',
            ]"
        ></div>

        <header
            :class="[
                'fixed top-0 w-full bg-white text-sm md:static md:top-auto',
                activePanel === 'mobileMenu' ? 'z-20' : 'z-10',
            ]"
        >
            <nav
                class="flex flex-row flex-wrap items-center justify-between py-3 border-b container-dashboard border-gray-light md:py-6"
            >
                <div class="shrink-0">
                    <Link :href="route('index')">
                        <img
                            src="/assets/images/logo-dark.svg"
                            alt="TrendExpress dark logo"
                            class="hidden w-auto h-12 md:block"
                        />

                        <img
                            src="/assets/images/logo.svg"
                            alt="TrendExpress logo-mark"
                            class="block w-auto h-12 md:hidden"
                        />
                    </Link>
                </div>
                <div class="block md:hidden">
                    <button
                        class="text-charcoal hover:text-gray-medium flex cursor-pointer items-center p-1.5 transition duration-300"
                        @click="togglePanel('mobileMenu')"
                    >
                        <MenuIcon
                            :class="
                                activePanel !== 'mobileMenu'
                                    ? 'block'
                                    : 'hidden'
                            "
                        />
                        <CloseIcon
                            :class="
                                activePanel === 'mobileMenu'
                                    ? 'block'
                                    : 'hidden'
                            "
                        />
                    </button>
                </div>
                <div
                    class="items-center hidden space-x-5 font-medium text-charcoal right-nav md:flex"
                >
                    <div class="add-after">locale</div>
                    <div class="add-after">
                        <Link
                            class="flex flex-row items-center cursor-pointer"
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            <LogoutIcon class="mr-1" />
                            <span>Log Out</span>
                        </Link>
                    </div>
                    <div
                        class="flex flex-row cursor-pointer"
                        @click="togglePanel('profile')"
                    >
                        <span>{{
                            $page.props.auth.user.surname +
                            ' ' +
                            $page.props.auth.user.name
                        }}</span>

                        <ChevronRightIcon />
                    </div>
                </div>
            </nav>

            <!-- Mobile nav -->
            <div
                :class="[
                    'container-dashboard absolute left-0 z-50 w-full space-y-2 bg-white py-4 md:hidden',
                    activePanel === 'mobileMenu' ? 'block' : 'hidden',
                ]"
            >
                <a
                    class="text-charcoal bg-off-white flex w-full flex-row justify-between rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                    @click="togglePanel('profile')"
                >
                    <span>Profile</span>
                    <ChevronRightIcon class="text-gray-medium" />
                </a>
                <div class="text-lg font-semibold">Language</div>
                <div class="space-y-2">
                    <a
                        href="#"
                        class="bg-off-white text-red-brand block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                    >
                        English
                    </a>
                    <a
                        href="#"
                        class="text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                    >
                        Turkmen
                    </a>
                    <a
                        href="#"
                        class="text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                    >
                        Russian
                    </a>
                </div>
                <div class="my-5 border-b border-gray-light"></div>
                <Link
                    class="text-charcoal bg-off-white flex w-full flex-row justify-between rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                    :href="route('logout')"
                    method="post"
                    as="button"
                >
                    <span>Log Out</span>
                    <LogoutIcon class="text-gray-medium" />
                </Link>
            </div>
        </header>

        <main class="my-24 container-dashboard text-charcoal md:mt-6 md:mb-0">
            <div class="flex space-x-6 flex-nowrap">
                <div
                    :class="[
                        'fixed bottom-0 left-0 w-full rounded-tl-[20px] rounded-tr-[20px] bg-white p-4 md:static md:bottom-auto md:left-auto md:z-auto md:block md:w-60 md:rounded-none md:p-0',
                        activePanel === 'filter'
                            ? 'z-20 block'
                            : 'z-auto hidden',
                    ]"
                >
                    <div class="flex flex-row justify-between mb-5 md:hidden">
                        <div class="text-charcoal text-[1.75rem] font-bold">
                            Filter
                        </div>

                        <button
                            @click="togglePanel('filter')"
                            class="text-charcoal hover:text-gray-medium flex cursor-pointer items-center p-1.5 transition duration-300"
                        >
                            <CloseIcon />
                        </button>
                    </div>

                    <FilterForm :statuses @filter-change="handleFilterChange" />
                </div>

                <div
                    class="md:border-gray-light mb-8 w-full md:w-[calc(100%-264px)] md:border-l md:pl-6"
                >
                    <div
                        v-if="Object.keys(cargos.data).length"
                        class="space-y-6"
                    >
                        <template v-for="(cargo, key) in cargosList" :key>
                            <div
                                v-if="
                                    key === 0 ||
                                    cargosList[key - 1].current_status.en !==
                                        cargo.current_status.en
                                "
                                :class="[
                                    'mb-4 text-xl leading-tight font-bold lg:mb-6 lg:text-2xl',
                                    { 'mt-4 lg:mt-6': key !== 0 },
                                ]"
                            >
                                {{ cargo.current_status.en }}
                            </div>

                            <CargoCard :cargo :statuses :cargoIndex="key" />
                        </template>
                    </div>
                    <div v-else class="font-medium text-center">
                        Sorry, we couldn't find that cargo. Please check your
                        tracking number or search filters.
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div
        :class="[
            'absolute right-0 bottom-0 z-30 min-h-166.75 w-full overflow-y-auto rounded-tl-[20px] rounded-tr-[20px] bg-white p-4 md:top-0 md:bottom-auto md:h-screen md:w-89 md:rounded-none md:p-5 lg:w-md',
            activePanel === 'profile' ? 'block' : 'hidden',
        ]"
    >
        <div class="flex flex-row justify-between mb-4 lg:mb-6">
            <div class="text-2xl font-bold lg:text-[1.75rem]">Profile</div>
            <button
                @click="togglePanel('profile')"
                class="text-charcoal hover:text-gray-medium flex cursor-pointer items-center p-1.5 transition duration-300"
            >
                <CloseIcon />
            </button>
        </div>

        <div class="text-sm">
            <ProfileForm :user="user" @success="closeAllModal" />
        </div>
    </div>

    <div
        class="fixed bottom-0 block w-full p-4 bg-white shadow-top-subtle md:hidden"
    >
        <button
            @click="togglePanel('filter')"
            class="block w-full py-3 text-base font-semibold text-center text-white cursor-pointer bg-red-brand rounded-xl"
        >
            Filters
        </button>
    </div>
</template>

<script setup lang="ts">
// Import Use Ref Props&Emits Computed Method Hooks
import CargoCard from '@/Components/Auth/CargoCard.vue';
import FilterForm from '@/Components/Auth/FilterForm.vue';
import ProfileForm from '@/Components/Auth/ProfileForm.vue';
import ChevronRightIcon from '@/Components/Icons/ChevronRightIcon.vue';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import LogoutIcon from '@/Components/Icons/LogoutIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import {
    ApiResponse,
    CargoData,
    PaginatedResponse,
    StatusData,
    UserData,
} from '@/types/data';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps<{
    statuses: StatusData[];
    cargos: PaginatedResponse<CargoData>;
    user: ApiResponse<UserData>;
}>();

type Panel = 'mobileMenu' | 'filter' | 'profile' | null;
let scrollTimeout: ReturnType<typeof setTimeout> | null = null;
const activePanel = ref<Panel>(null);
const cargosList = ref([...props.cargos.data]);
const nextPage = ref(props.cargos.links.next);
const loadingMore = ref(false);
const isPaginating = ref(false);

const togglePanel = (panel: Panel) => {
    activePanel.value = activePanel.value === panel ? null : panel;
};

const closeAllModal = () => {
    activePanel.value = null;
};

const handleFilterChange = (filters: {
    statusIds: number[];
    sortOrder: 'asc' | 'desc';
    search: string;
}) => {
    router.get(
        route('dashboard'),
        {
            statusIds: filters.statusIds,
            sort: filters.sortOrder,
            search: filters.search,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
};

const loadMore = () => {
    if (!nextPage.value || loadingMore.value) return;

    loadingMore.value = true;
    isPaginating.value = true;

    router.get(
        nextPage.value,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            only: ['cargos'],
            onSuccess: (page: any) => {
                const newCargos = page.props.cargos;
                cargosList.value.push(...newCargos.data);
                nextPage.value = newCargos.links.next;
                loadingMore.value = false;
                isPaginating.value = false;
            },
            onError: () => {
                loadingMore.value = false;
                isPaginating.value = false;
            },
        },
    );
};

watch(
    () => props.cargos,
    (newCargos) => {
        if (isPaginating.value) return; // skip reset during pagination
        cargosList.value = [...newCargos.data];
        nextPage.value = newCargos.links.next;
    },
);

const handleScroll = () => {
    if (scrollTimeout) return;

    scrollTimeout = setTimeout(() => {
        const scrollPosition = window.innerHeight + window.scrollY;
        const threshold = document.body.offsetHeight - 300;

        if (scrollPosition >= threshold) {
            loadMore();
        }

        scrollTimeout = null;
    }, 150);
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (scrollTimeout) clearTimeout(scrollTimeout);
});
</script>
