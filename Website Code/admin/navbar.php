<style>
        body {
            background-color: rgb(229, 235, 237);
           
            margin: 0;
            padding: 0;
            
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            color: white;
            border-radius: 2px;
            border: 2px solid #000;
            background: #f0ffea;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
        }

        .icons {
            display: flex;
        }

        .icons a {
            color: #000;
            font-size: 16px;
            text-decoration: none;
            padding: 10px 20px;
            margin-right: 10px;
            font-size: 23px;
            
        }

        .icons a:hover {
            background-color: rgb(229, 235, 237);
        }

        .right-items {
            margin-left: auto; 
        }

      
        @media only screen and (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .right-items {
                margin-left: 0;
                margin-top: 10px;
            }

            .icons a {
                padding: 10px;
                margin-right: 0;
            }
        }
    </style>
</head>

<body class="body-home">
    <div class="navbar">
        <div class="icons left-items">
            <a class="navItem" href="admin-home.php">Home</a>
            <a class="navItem" href="admin-dashboard.php">Dashboard</a>
            <a class="navItem" href="school.php">Schools</a>
            <a class="navItem" href="teacher.php">Teachers</a>
            <a class="navItem" href="student.php">Students</a>
            <a class="navItem" href="community.php">Communities</a>
            <a class="navItem" href="member.php">Members</a>
            <a class="navItem" href="admin.php">Add New Admin</a>
        </div>

        <div class="icons right-items">
            <a class="navItem" href="../logout.php">Logout</a>
        </div>
    </div>
</body>
