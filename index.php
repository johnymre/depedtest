<?php 
include_once('connection.php'); 

$query="SELECT * from depedemployee"; 
$result=$con->query($query); 

$query1="SELECT COUNT(ID) as cemp from depedemployee"; 
$result1=$con->query($query1); 

$query2="SELECT COUNT(jobtitle) as job from depedemployee WHERE jobtitle ='Job Order'"; 
$result2=$con->query($query2); 

$query3="SELECT COUNT(jobtitle) as perma from depedemployee WHERE jobtitle ='Permanent'"; 
$result3=$con->query($query3); 

$query5="SELECT COUNT(jobtitle) as casual from depedemployee WHERE jobtitle ='Casual'"; 
$result5=$con->query($query5); 

$query6="SELECT COUNT(jobtitle) as lsb from depedemployee WHERE jobtitle ='Local School Board'"; 
$result6=$con->query($query6); 

$query4="SELECT position, COUNT(position) as cpos, gender FROM depedemployee GROUP BY position, gender ORDER BY gender DESC"; 
$result4=$con->query($query4); 

?> 

<!DOCTYPE html>
<html> 
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#example thead');
 
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        responsive: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
                            e.stopPropagation();
 
                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    });
});
    </script>
    
	<head> 
		<title> Fetch Data From Database </title> 
	</head> 
	<body class="bg-dark">
    <div class="spacer"></div> 
    <div class="container" style="height:auto; width:100%;">
        <div class="row align-items-center justify-content-center">
            <div class="card align-baseline m-3 p-4">
                    <h1>Employee Count</h1>
                    <?php if($rows=$result1->fetch_assoc())?> 
                    <span class="fontbold text-center " style="font-size:40px;"><?php echo $rows['cemp']; ?> </span>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            
            <div class="card align-baseline m-3 p-4">
                    <h1>Job Order</h1>
                    <?php if($rows=$result2->fetch_assoc())?> 
                    <span class="fontbold text-center" style="font-size:40px;"><?php echo $rows['job']; ?> </span>
            </div>
            <div class="card align-baseline m-3 p-4">
                    <h1>Permanent</h1>
                    <?php if($rows=$result3->fetch_assoc())?> 
                    <span class="fontbold text-center" style="font-size:40px;"><?php echo $rows['perma']; ?> </span>
            </div>
            <div class="card align-baseline m-3 p-4">
                    <h1>Casual</h1>
                    <?php if($rows=$result5->fetch_assoc())?> 
                    <span class="fontbold text-center" style="font-size:40px;"><?php echo $rows['casual']; ?> </span>
            </div>
            <div class="card align-baseline m-3 p-4">
                    <h1>Local School Board</h1>
                    <?php if($rows=$result6->fetch_assoc())?> 
                    <span class="fontbold text-center" style="font-size:40px;"><?php echo $rows['lsb']; ?> </span>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
        <?php while($rows=$result4->fetch_assoc()){
                ?> 
                <div class="card align-baseline m-3 p-4">
                    <h1><?php echo $rows['position']; ?></h1>
                    <div class="text-center align-center justify-content-center">
                        <h6> <?php echo $rows['gender']; ?> </h6>
                        <div class="d-flex align-baseline justify-content-center">
                        <span class="container fontbold text-center" style="font-size:40px;"><?php echo $rows['cpos']; ?> </span>
                        </div>
                        
                    </div>
                </div>
        <?php
            }
        ?> 
        
        </div>
    </div>
    <div class="spacer small"></div>
    <div class="container-fluid text-right justify-content-center" style="height: auto; width:80%;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Add Employee
    </button>
    </div>
    <div class="spacer small"></div>
    <div class="d-flex align-items-center justify-content-center" style="height: auto; width:100%;">
        <div class="card" style="width:80%; padding:30px;">
        <table id="example" class="table table-striped font-family" style="width:100%; height:100%; margin:0;">
        <thead>
            <tr> 
                <th> ID </th> 
                <th> Name </th> 
                <th> Job Title </th> 
                <th> Position </th> 
                <th> Gender </th> 
            </tr> 
        </thead>
        <tbody>
            <?php while($rows=$result->fetch_assoc()) 
            { 
            ?> 
            <tr> <td><?php echo $rows['ID']; ?></td> 
            <td><?php echo $rows['name']; ?></td> 
            <td><?php echo $rows['jobtitle']; ?></td> 
            <td><?php echo $rows['position']; ?></td> 
            <td><?php echo $rows['gender']; ?></td> 
            </tr> 
        <?php 
                } 
            ?> 
            </tbody>
        </table> 
        </div>
    </div>
    <div class="spacer"></div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Insert Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form id="submit-button" method="post">
                    <div class="form-group text-left">
                        <label for="empname" class="col-form-label">Name</label>
                        <input type="text" class="form-control" name="empname" id="empname" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="jobtitle">Job Title</label>
                        <select class="form-control" name="jobtitle" id="jobtitle">
                        <option>Permanent</option>
                        <option>Casual</option>
                        <option>Job Order</option>
                        <option>Local School Board</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <select class="form-control" name="position" id="position">
                        <option>Admin Aide I</option>
                        <option>Admin Aide II</option>
                        <option>Admin Aide III</option>
                        <option>Teacher I</option>
                        <option>Teacher II</option>
                        <option>Teacher III</option>
                        <option>Teacher IV</option>
                        <option>Teacher V</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                        <option>Male</option>
                        <option>Female</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="Submit">Save</button>
                    
                    </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusErrorsModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
			<div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
				<div class="modal-content"> 
					<div class="modal-body text-center p-lg-4"> 
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
							<circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" /> 
							<line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
							<line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" /> 
						</svg> 
						<h4 class="text-danger mt-3" id="errormess">Invalid email!</h4> 
						<p class="mt-3" id="mess">This email is already registered, please login.</p>
                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
					</div> 
				</div> 
			</div> 
		</div>
    <div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
			<div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
				<div class="modal-content"> 
					<div class="modal-body text-center p-lg-4"> 
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
							<circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
							<polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " /> 
						</svg> 
						<h4 class="text-success mt-3">Oh Yeah!</h4> 
						<p class="mt-3">You have successfully registered and logged in.</p>
						<button type="button" class="btn btn-secondary btn-success" data-dismiss="modal" onClick="window.location.reload();">Close</button>
					</div> 
				</div> 
			</div> 
	</body> 
    <script>
        $(document).ready(function() {
            $("#submit-button").submit(function(e) {

                var url = "crud/insert.php"; // the script where you handle the form input.
                var form=$("#submit-button");
                $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                dataType: 'json',
                success: function(data) 
                {
                    if(data.response == 'Error'){
                        $('#statusErrorsModal').modal('show');
                        $('#errormess').html(data.errmess);
                        $('#mess').html(data.mess);
                    }else{
                        $('#statusSuccessModal').modal('show');
                        $("#submit-button")[0].reset();
                        $('#exampleModalCenter').modal('hide');
                    }
                }
                })

                e.preventDefault(); // avoid to execute the actual submit of the form.
                });
            });
    </script>
	</html>