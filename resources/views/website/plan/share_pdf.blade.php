<html>
    <head>
        <style>
            .btn {
                display: inline-block;
                font-weight: 400;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                border: 1px solid transparent;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: .25rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }

            .btn-primary {
                background-color: #007bff;
            }    
        </style>
    </head>
    <body>
        <h3>Hello</h3><br>
        <h4>I am sharing my lesson with you in pdf format so please find attached document for more detail.</h4><br>
        <a href="{{$shareLink}}" class="btn btn-success">Add Shared Lession</a>
        Thanks.
    </body>
</html>