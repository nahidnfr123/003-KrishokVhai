import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import relativeTime from 'dayjs/plugin/relativeTime';
import customParseFormat from 'dayjs/plugin/customParseFormat';

dayjs.extend(utc);
dayjs.extend(relativeTime);
dayjs.extend(customParseFormat);


// Filter date format ...
Vue.filter('dateFormatMDY', function (created, format = "MM-DD-YYYY") {
    if (created) {
        return dayjs(created).format(format);
    }
});

Vue.filter('dateFormatAgo', function (created) {
    if (created) {
        //return dayjs(created).format("MM-DD-YYYY");
        return dayjs.utc(created).fromNow();
    }
});


Vue.filter('dateFormatCustom', function (created, format = "MM-DD-YYYY") {
    if (created) {
        //return dayjs(created).format("MM-DD-YYYY");
        const created_at = dayjs(created).format(format);
        if (dayjs().isSame(created_at, 'date')) {
            return created_at + ' -- ( Today )';
            //return dayjs.utc(created).fromNow();
        } else {
            return created_at;
        }
    }
});

Vue.filter('dateFormatForTodo', function (created, format = "ddd, DD MMM YYYY") {
    if (created) {
        //return dayjs(created).format("MM-DD-YYYY");
        const created_at = dayjs(created).format(format);
        if (dayjs().isSame(created_at, 'date')) {
            return created_at + ', ( added: ' + dayjs.utc(created).fromNow() + ' )';
        } else {
            return created_at;
        }
    }
});


