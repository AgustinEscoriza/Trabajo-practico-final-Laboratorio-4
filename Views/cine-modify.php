
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Modify Cinema</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                         <th>Capacity</th>
                         <th>Ticket Value</th>
                    </thead>
                    <tbody>
                            <tr>
                                <td><?php echo $cine->getName() ?></td>
                                <td><?php echo $cine->getAdress() ?></td>
                                <td><?php echo $cine->getCapacity() ?></td>
                                <td><?php echo $cine->getTicketValue() ?></td>
                            </tr>
                         </tr>
                    </tbody>
               </table>
               <form action="<?php echo FRONT_ROOT ?>Cine/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" value="" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Adress</label>
                                   <input type="text" name="adress" value="" class="form-control">
                              </div>
                         </div>
                        
                    </div>
                    <div class ="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Capacity</label>
                                   <input type="text" name="capacity" value="" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Ticket Value</label>
                                   <input type="text" name="ticketValue" value="" class="form-control">
                              </div>
                         </div>
                         
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Modify</button>
               </form>
          </div>
     </section>
</main>