user_page_size = db.settings.findOne({
    name: "user_page_size" 
});

admin_page_size = db.settings.findOne({
    name: "admin_page_size" 
});

if(user_page_size == null) {
    db.settings.insertOne({
        name: 'user_page_size',
        value: 10
  })
}

if(admin_page_size == null) {
    db.settings.insertOne({
        name: 'admin_page_size',
        value: 10
  })
}
