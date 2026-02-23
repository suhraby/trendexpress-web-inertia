export interface UserData {
    identifier: string;
    name: string;
    surname: string;
    email: string;
    phone_number: string;
    has_default_password: boolean;
}

export interface StatusData {
    id: number;
    name: LocalizedText;
    icon: string;
}

interface CargoStatusData {
    id: number;
    name: LocalizedText;
    status_at: string;
    note: string;
}

export interface CargoImageData {
    id: string;
    src: string;
    thumbnail: string;
}

export interface CargoData {
    number: string;
    weight: string;
    received_address: string;
    current_status_id: number;
    current_status: LocalizedText;
    current_status_icon: string;
    created_at: string;
    status_histories: CargoStatusData[];
    images: CargoImageData[];
}

export interface SectionData {
    name: string;
    title?: LocalizedText;
    header?: LocalizedText;
    description?: LocalizedText;
    image?: string;
    button_text?: LocalizedText;
    button_link?: string;
    search_label?: LocalizedText;
    search_placeholder?: LocalizedText;
    search_button_text?: LocalizedText;
    items: ListItem[];
}

export interface ContactInfoData {
    icon: string;
    context: string;
    value: string;
    value_localization: LocalizedText;
    type: string;
}

export interface LocalizedText {
    en: string;
    ru: string;
    tm: string;
}

export interface ListItem {
    title: LocalizedText;
    description?: LocalizedText;
    icon?: string;
    image?: string;
}

export interface ApiResponse<T> {
    data: T;
}
