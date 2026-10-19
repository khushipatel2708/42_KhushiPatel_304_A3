const express = require("express");
const app = express();

app.get("/students", (req, res) => {
    res.json([
        { id: 1, name: "Khushi", city: "Surat" },
        { id: 2, name: "Rahul", city: "Ahmedabad" }
    ]);
});

app.listen(3000, () => {
    console.log("Server running on port 3000");
});