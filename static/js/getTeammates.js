function getTeammates(e) {
    e.preventDefault();
    var teamId = document.getElementById("teammates");
    teamId.innerHTML = "";
    var data = {
        user_id: document.getElementById("user_id").value
    };
    fetch('http://localhost:8080/GameOverTest/api/user/index.php', {
        method : "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response=>{
        return response.text();
    }).then(data => {
        teammates = JSON.parse(data);
        var html = "";
        if(teammates.success) {
            html = createTeammates(teammates);
        } else {
            html = createAlert(teammates.message);
        }
        console.log(html);
        teamId.innerHTML = html;       
    });
}

function createTeammates(teammates){
    var html = "";
    teammates.data.forEach(teammate => {
        html += `<div class="card border-secondary mb-3" style="max-width: 20rem;">
                <div class="card-header"><strong>Teammate</strong>: ${teammate.nickName}</div>
                <div class="card-body">
                <h4 class="card-title"><strong>Name</strong>: ${teammate.firstName} ${teammate.lastName}</h4>
                <p class="card-text"><strong>Teammate</strong>: ${teammate.nickName} <strong>Αged</strong>: ${teammate.age} is on your team with <strong>ID</strong>: ${teammate.user_id}</p>
                </div>
            </div>`
        });
        return html;
}

function createAlert(message) {
    return `<div class="alert alert-dismissible alert-warning" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4 class="alert-heading">Something went wrong!</h4>
                        <p class="mb-0">${message}</p>
                    </div>`;
}

document.getElementById("myForm").addEventListener("submit", getTeammates);

