const dataService = {
    getYesterdayDate(){
        const today = new Date();
        let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+(today.getDate()-1);
        const time = today.getHours() + ":" + today.getMinutes();
        date = date.split('-').reverse()
        for(let i = 0; i<3;i++){
            if(date[i].length<2)
            {
                date[i] = '0'+date[i]
            }
        }
        date = date.join('.') + ','
        const dateTime = date +' '+ time;

        return dateTime
    }
};

export default dataService;