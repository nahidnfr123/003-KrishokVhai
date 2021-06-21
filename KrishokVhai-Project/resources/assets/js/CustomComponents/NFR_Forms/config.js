// # Theme Configuration .....
const theme_color = 'bg-blue-700';
const theme_color_hover = 'bg-blue-600';

const border = 'ring-blue-700';

const background_color_dark = 'dark:bg-gray-800';
const background_color_light = 'bg-white';

const label_color_light = 'text-gray-800';
const label_color_dark = 'dark:text-gray-300';

const input_with_label_color_dark = 'text-purple-700';
const input_with_label_color_light = 'dark:text-purple-500';

//-----------------------------------------------------------------------//
export const default_label_style = 'block font-medium text-sm ' + label_color_light + ' ' + label_color_dark;

export const default_text_input_style = 'w-full leading-tight rounded-lg w-full py-2 px-4 text-sm text-gray-700 ' +
    'placeholder-gray-500 placeholder-opacity-60 shadow ' + background_color_light + ' ' + background_color_dark +
    ' dark:text-gray-100 hover:shadow-md ' +
    ' focus:shadow-lg focus:outline-none focus:ring-1 focus:' + border + ' focus:border-transparent ';

export const default_radio_input_style = 'customRadioDesign rounded-md border-2 border-' + border +
    ' ' + background_color_light + ' ' + background_color_dark + ' mr-2';

export const input_with_label_style = 'text-xs mr-6 pt-1 ' + input_with_label_color_light + ' ' + input_with_label_color_dark;

export const default_button_style = "shadow-md px-2 py-1 bg-indigo-600 border border-transparent rounded-md text-xs text-white tracking-widest hover:bg-indigo-500 active:bg-indigo-600 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150";
