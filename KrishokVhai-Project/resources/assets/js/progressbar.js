import VueProgressBar from 'vue-progressbar';

const options = {
    color: '#03b1fd',
    failedColor: 'red',
    thickness: '5px',
    transition: {
        speed: '0.4s',
        opacity: '1s',
        termination: 400
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)

// Vue.use(VueProgressBar, {
//     color: 'rgb(143, 255, 199)',
//     failedColor: 'red',
//     height: '4px',
//     transition: {
//         speed: '0.4s',
//         opacity: '0.6s',
//         termination: 300
//     },
// })


