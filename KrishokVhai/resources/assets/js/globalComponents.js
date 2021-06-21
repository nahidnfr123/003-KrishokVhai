import FormComponents from './CustomComponents/NFR_Forms/index'
import Loading from "./CustomComponents/Loading";

const GlobalComponents = {
    install (Vue) {
        // Custom Form Components ....
        Vue.component('Custom_Text_Input', FormComponents.TextInput) // Text Input includes :- text, email, password, textarea, date, number, tel, etc ...
        Vue.component('Custom_Radio_Input', FormComponents.Radio) // Radio Input includes :- radio button
        Vue.component('Custom_Checkbox_Input', FormComponents.Checkbox) // Checkbox Input includes :- checkbox
        Vue.component('Custom_MultipleCheckbox_Input', FormComponents.MultipleCheckbox) // MultipleCheckbox Input includes :- checkbox
        Vue.component('Custom_Select_Input', FormComponents.Select) // Checkbox Input includes :- Select option
        Vue.component('Switch_Input', FormComponents.Switch) // Checkbox Input includes :- Select option
        Vue.component('Repeat_Text_Input', FormComponents.RepeatTextInput) // Checkbox Input includes :- Select option
        Vue.component('Custom_Loading_Button', FormComponents.LoadingButton) // Checkbox Input includes :- Select option

        // Loading Component ...
        Vue.component('Loading', Loading) // Checkbox Input includes :- Select option

        // Custom Snackbar Components
    }
}

export default GlobalComponents
