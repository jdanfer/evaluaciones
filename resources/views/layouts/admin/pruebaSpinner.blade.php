<!DOCTYPE html>
<html>
<head>
    <title>How To Add JQuery Ajax Loading Spinner in Laravel Example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>
<body>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>How To Add JQuery Ajax Loading Spinner in Laravel Example</h3>
                    </div>
                    <div class="card-body">
                     
                        <form method="POST" action="#" id="postForm">
                            {{ csrf_field() }}
                              
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Body:</strong>
                                        <textarea name="body" rows="3" class="form-control">{{ old('body') }}</textarea>
                                    </div>  
                                </div>
                            </div>
                     
                            <div class="form-group">
                                <button class="btn btn-success btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
  
<script type="text/javascript">
      
    $("#postForm").submit(function(e){
        e.preventDefault();
  
        /*------------------------------------------
        --------------------------------------------
        Add Loading Spinner to Button
        --------------------------------------------
        --------------------------------------------*/
        $(".btn-submit").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');
  
        $.ajax({
            url: "https://jsonplaceholder.typicode.com/posts",
            type: "POST",
            data: {
                title: $("input[name='title']").val(),
                body: $("textarea[name='body']").val()
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
  
                /*------------------------------------------
                --------------------------------------------
                Remove Loading Spinner to Button
                --------------------------------------------
                --------------------------------------------*/
                $(".btn-submit").find(".fa-spinner").remove();
                $(".btn-submit").removeAttr("disabled");
            }
        });
    });
      
</script>
  
</html>