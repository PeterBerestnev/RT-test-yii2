export function getYesterdayDate() {
    const today = new Date();
    let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + (today.getDate() - 1);
    let time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
    date = date.split('-')
    time = time.split(':')
    for (let i = 0; i < 3; i++) {
        if (date[i].length < 2) {
            date[i] = '0' + date[i]
        }
        if(time[i].length < 2){
            time[i] = '0' + time[i]
        }
    }
    date = date.join('-') + ' '
    time = time.join(':')
    
    const dateTime = date + time;

    return dateTime
}

