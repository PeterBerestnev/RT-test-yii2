if (db.getUser("my_user") == null) { 
    db.createUser({
        user: $_ENV['DB_USER'],
        pwd: $_ENV['DB_PASS'],
        roles: [{
            role: "readWrite",
            db: $_ENV['DB_NAME']
        }]
    })
}