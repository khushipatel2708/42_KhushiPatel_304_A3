async function getStudents() {
    try {
        const response = await fetch(
            "http://localhost/shopping/students_api.php"
        );

        const students = await response.json();

        students.forEach(s => {
            console.log("ID:", s.id);
            console.log("Name:", s.name);
            console.log("City:", s.city);
            console.log("----------------");
        });
    } catch (error) {
        console.log("Error:", error.message);
    }
}

getStudents();