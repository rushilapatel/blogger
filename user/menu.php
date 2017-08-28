<head>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
}

.active {
    background-color: #4CAF50;
}
</style>
</head>
<body>
<h1>Blog</h1>

<ul id='adminmenu'>
	<li class="active"><a href='index.php'>Blog</a></li>
	<li><a href="../" target="_blank">View Website</a></li>
	<li><a href='logout.php'>Logout</a></li>
</ul>
<div class='clear'></div>
<hr />
</body>