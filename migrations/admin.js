user = db.user.findOne({
    username: "Peter" 
});

if (user == null) {
    db.user.insertOne({
        username: "Peter",
        email: "Some@mail.com", 
        password_hash: "$2y$13$nb4MCtpIm97jSGkSRjD8H.ufb/..k5ldLPY9s4j6Nzwp3UWqrD8zi", 
        access_token: "JkCY95TyZyqKNU9au2Ez1XnxucDeXKULItiHnlbFvMmwwj69hvy_Yq9DNcnW7qrc2uPK3o3U8I1hvd9eDlutWJVqfyN7lB4odGvxstPqje9ccmblC1JrWmp89u_N_dOOBKe1YZrJnxYQtaFn4jsdbt7UhsJrITr467OLlvdWrV0q_GWuZ2l5IHBcxxJJwxIDrOVFgzfV3hp9F0cVCielJFGJxGCC2scNNdvYRAryj3Q8x6_ztBTkli-QAkmDfGU"
    })
}