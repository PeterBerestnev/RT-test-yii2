if (db.getUser("dev_user") == null) { 
    db.createUser({
        user: "dev_user",
        pwd: "wwsasdkasdwqasd",
        roles: [{
            role: "readWrite",
            db: "GoodNews"
        }]
    })
}