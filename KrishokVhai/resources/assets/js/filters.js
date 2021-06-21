// Uppercase word filters
import Vue from "vue";

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});


//Vue.filter('capitalize', function(text){return text.charAt(0).toUpperCase() + text.slice(1);});
Vue.filter('ucWords', function (text) {
    return text.replace(/\b\w/g, c => c.toUpperCase());
});


const filter = function (text, length, clamp) {
    clamp = clamp || '...';
    let node = document.createElement('div');
    node.innerHTML = text;
    let content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
};
Vue.filter('truncate', filter);


