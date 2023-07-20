<!DOCTYPE html>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title></title>

    <style type="text/css">
        /* PRICE TABLE */
.row-flex {
    display: flex;
    flex-wrap: wrap;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    -moz-flex-wrap: wrap;
}

.price-table {
    max-width: 400px;
    min-height: 320px;
    background-color: #fff;
    border-radius: 0 0 0 25px;
    border: 1px solid #ccc;
    box-shadow: 5px 5px 8px #ccc;
    display: block;
    margin: 10px auto;
    padding: 0 0 8px 0;
    text-align: center;
}

.price-table span {
    display: block;
}

.price-table span:first-child {
    padding: 16px 0 0 0;
    font-size: 2em;
    text-transform: uppercase;
    font-weight: bold;
}

.price-table span:nth-child(2) {
    padding: 0 0 16px 0;
}

.price-table span:nth-child(3) {
    padding: 8px 0;
    font-weight: bold;
    font-size: 1.2em;
}

.price-table > ul {
    list-style: none;
    display: block;
    padding: 0;
    margin: 0;
}

.price-table > ul > li {
    display: block;
    padding: 8px 0;
}

.price-table > ul > li:first-child {
    border-top: 1px solid #ccc;
}

.price-table > ul > li {
    border-bottom: 1px solid #ccc;
}

.price-table a,
.price-table a:active,
.price-table a:focus,
.price-table a:hover,
.price-table a:visited {
    text-transform: uppercase;
    display: inline-block;
    padding: 8px 16px;
    text-decoration: none;
    font-weight: bold;
    transition-duration: .2s;
}

/* Colors */
.pt-bg-black span:first-child {
    background-color: #212121;
    color: #fcfcfc;
}

.pt-bg-black span:nth-child(2) {
    background-color: #212121;
    color: #D5D8DC;
}

.pt-bg-black a {
    border: 3px solid #212121;
    color: #212121;
    margin-top: 8px;
}

.pt-bg-black a:hover {
    background-color: #212121;
    color: #fff;
} /* End Color Black */

.pt-bg-green span:first-child {
    background-color: #27AE60;
    color: #fcfcfc;
}

.pt-bg-green span:nth-child(2) {
    background-color: #27AE60;
    color: #D5D8DC;
}

.pt-bg-green a {
    border: 3px solid #27AE60;
    color: #27AE60;
    margin-top: 8px;
}

.pt-bg-green a:hover {
    background-color: #27AE60;
    color: #fff;
} /* End Color Green */

.pt-bg-red span:first-child {
    background-color: #C0392B;
    color: #fcfcfc;
}

.pt-bg-red span:nth-child(2) {
    background-color: #C0392B;
    color: #D5D8DC;
}

.pt-bg-red a {
    border: 3px solid #C0392B;
    color: #C0392B;
    margin-top: 8px;
}

.pt-bg-red a:hover {
    background-color: #C0392B;
    color: #fff;
} /* End Color Red */

.pt-bg-blue span:first-child {
    background-color: #2980B9;
    color: #fcfcfc;
}

.pt-bg-blue span:nth-child(2) {
    background-color: #2980B9;
    color: #D5D8DC;
}

.pt-bg-blue a {
    border: 3px solid #2980B9;
    color: #2980B9;
    margin-top: 8px;
}

.pt-bg-blue a:hover {
    background-color: #2980B9;
    color: #fff;
} /* End Color Blue */
/* END PRICE TABLE */
    </style>
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px; margin-left: 35%">
            <div class="col-md-6">
                <?php echo $this->Html->link('<button class="btn btn-info btn-md"><i class="fa fa-circle-o-notch fa-spin"></i> Annual Pricing</button>',array('controller'=>'dashboard','action'=>'subscription','a'),array('escape'=>false)); ?>
                
                <?php echo $this->Html->link('<button class="btn btn-info btn-md"><i class="fa fa-refresh fa-spin"></i> Monthly Pricing</button>',array('controller'=>'dashboard','action'=>'subscription','m'),array('escape'=>false)); ?>
                
            </div>
        </div>
    <div class="row row-flex">
        <?php foreach($data as $data){ ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="price-table <?php echo $data['color']; ?>">
                <div>
                    <span><?php echo $data['name']; ?></span>
                    <span><?php echo $data['price'].' GHS'.'<br>'; 
                    if($type == 'a'){
                        echo 'per month – billed annually';
                        $total_price = $data['price'] * 12;
                    }
                    else{
                        echo 'per month';
                        $total_price = $data['price'];
                    }
                    ?></span>
                    <span>Features included!</span>
                </div>
                <ul>
                    <?php foreach($data['package_items'] as $items){ ?>
                        <li><?php echo $items['name']; ?></li>
                    <?php } ?>
                </ul>
                <?php echo $this->Html->link('purchase',array('controller'=>'dashboard','action'=>'order',$data['id'],$type)); ?>
            </div>
        </div>
        <?php } ?>

    </div>
</div>


</body>
</html>