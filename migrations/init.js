if (db.getUser("my_user") == null) { 
    db.createUser({
        user: "my_user",
        pwd: "my_password",
        roles: [{
            role: "readWrite",
            db: "my_database"
        }]
    })
}