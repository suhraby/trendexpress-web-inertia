<template>
    <Head title="Home page" />

    <Navbar />

    <main>
        <template v-for="(data, key) in sections.data" :key="key">
            <component
                v-if="key !== 4"
                :is="sectionMap[key as SectionKey]"
                :data="data"
            />
            <component
                v-else
                :is="sectionMap[key as SectionKey]"
                :data="data"
                :contactData="contacts.data"
            />
        </template>
    </main>

    <Footer />
</template>

<script setup lang="ts">
import AboutSection from '@/Components/Landing/AboutSection.vue';
import ContactSection from '@/Components/Landing/ContactSection.vue';
import Footer from '@/Components/Landing/Footer.vue';
import HeroSection from '@/Components/Landing/HeroSection.vue';
import MissionSection from '@/Components/Landing/MissionSection.vue';
import Navbar from '@/Components/Landing/Navbar.vue';
import ServiceSection from '@/Components/Landing/ServiceSection.vue';
import { ApiResponse, ContactInfoData, SectionData } from '@/types/data';
import { Head } from '@inertiajs/vue3';

type SectionKey = keyof typeof sectionMap;

const sectionMap = {
    0: HeroSection,
    1: MissionSection,
    2: AboutSection,
    3: ServiceSection,
    4: ContactSection,
} as const;

const props = defineProps<{
    canLogin?: boolean;
    sections: ApiResponse<SectionData[]>;
    contacts: ApiResponse<ContactInfoData[]>;
}>();
</script>
