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
