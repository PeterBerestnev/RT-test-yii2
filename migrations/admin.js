user = db.user.findOne({
    username: "Peter" 
});

if (user == null) {
    db.user.insertOne({
        username: "Peter",
        email: "Some@mail.com", 
        password_hash: "$2y$13$nb4MCtpIm97jSGkSRjD8H.ufb/..k5ldLPY9s4j6Nzwp3UWqrD8zi", 
    })
}