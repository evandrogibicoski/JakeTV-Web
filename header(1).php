<!--header-->
<div class="header" id="headerhr">
  <div class="header-top">
    <nav class="navbar navbar-default">
      <div class="container-fluid"> 
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <div class="navbar-brand">
          <img src="logo/JAKEtv_logo_drop.png" style="margin-top:8px;">
<!--            <h1><a href="index.html">zoo planet</a></h1>
-->          </div>
        </div>
        
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav" style="margin-top:5px;">
            <li class="active">
            <a href="index.php"  data-toggle="tooltip" data-placement="left" title="Home"><img src="images/1449241958_65.png"  class="imgicon">&nbsp;&nbsp;HOME<span class="sr-only" >(current)</span></a>
            </li>
            <?php
				if(isset($_SESSION['sessionid'])){ ?>
					<li>
                        <a href="likes.php"  data-toggle="tooltip" data-placement="left" title="Likes">
                            <img src="images/1449241840_138.png"  class="imgicon">&nbsp;&nbsp;LIKES
                        </a>
                    </li>
				<?php }else{ ?>
					<li>
                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" data-placement="left" title="Likes" style="cursor:pointer;">
                            <img src="images/1449241840_138.png"  class="imgicon">&nbsp;&nbsp;LIKES
                        </a>
                    </li>
				<?php }
				?>
            <?php
				if(isset($_SESSION['sessionid'])){ ?>
					<li>
                        <a href="bookmark.php"  data-toggle="tooltip" data-placement="left" title="Bookmarks">
                            <img src="images/1449241840_138.png"  class="imgicon">&nbsp;&nbsp;BOOKMARKS
                        </a>
                    </li>
				<?php }else{ ?>
					<li>
                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" data-placement="left" title="Bookmarks" style="cursor:pointer;">
                            <img src="images/1449241840_138.png"  class="imgicon">&nbsp;&nbsp;BOOKMARKS
                        </a>
                    </li>
				<?php }
				?>
                <?php
				if(isset($_SESSION['sessionid'])){ ?>
					<li>
                        <a href="category.php"  data-toggle="tooltip" data-placement="left" title="categories">
                            <img src="images/1449242452_folder.png"  class="imgicon">&nbsp;&nbsp;CATEGORIES
                        </a>
                    </li>
				<?php }else{ ?>
					<li>
                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" data-placement="left" title="Categories" style="cursor:pointer;">
                            <img src="images/1449242452_folder.png"  class="imgicon">&nbsp;&nbsp;CATEGORIES
                        </a>
                    </li>
				<?php }
				?>
            
            
          </ul>
        
        <!-- /.navbar-collapse --> 
      </div>
      <!-- /.container-fluid --> 
    </nav>
  </div>
  
</div>

</div>
<!--<div class="col-lg-12 col-sm-12">
<hr size="50">
</div>-->

<!--header--> 

