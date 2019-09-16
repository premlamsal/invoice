<template>
 <div>
     <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Create Invoice</h6>
            </div>
            <div class="card-body">
 <div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Invoice No.</label>
                Will be generated after Invoice Creation
        </div>
        <div class="form-group">
            <label>Customer</label>
            <input type="text" class="form-control" v-model="info.customer_name" v-on:Keyup="autoComplete">

           
                <b-button id="show-btn" @click="$bvModal.show('bv-modal-example')" class="btn btn-warning" style="margin-top: 8px;">
                       <span class="fa fa-plus-circle"></span>
                     Add Customer</b-button>

                      <b-modal id="bv-modal-example" hide-footer>
                        <template v-slot:modal-title>
                          Add Customer
                        </template>
                        <div class="d-block">
                              <div class="form-group">
                                <label for="Name">Name:</label>
                                <input type="text" class="form-control" v-model="customer.name">
                              </div>
                              <div class="form-group">
                                <label for="Address">Address:</label>
                                <input type="text" class="form-control" v-model="customer.address">
                              </div>
                               <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="phone" class="form-control" v-model="customer.phone">
                              </div>
                        </div>
                        <b-button class="mt-3" block @click="addCustomer">Add Customer</b-button>
                      </b-modal>

        </div>
        <div>
</div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
          <!--   <label>Customer Address</label>
            <textarea class="form-control" style="height: 7.6em" v-model="info.client_address"></textarea>
                
            -->
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" v-model="info.title">
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Invoice Date</label>
                <input type="date" class="form-control" v-model="info.invoice_date">
            </div>
            <div class="col-sm-6">
                <label>Due Date</label>
                <input type="date" class="form-control" v-model="info.due_date">
            </div>
        </div>
    </div>
</div>
<hr>

<table class="table table-bordered table-form">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item,index) in items">
            <td class="table-name">
                <input type="text" name="" class="form-control" placeholder="Product Name" v-model="item.product_name">
            </td>
            <td class="table-price">
                <input type="text" class="form-control" placeholder="Enter the price" v-model="item.price">
            </td>
            <td class="table-qty">
                <input type="text" class="form-control" placeholder="Quantity" v-model="item.quantity">
            </td>
            <td class="table-total">
                <span class="table-text" v-model="item.line_total">{{item.quantity * item.price}}</span>
            </td>
            <td class="table-remove">
                <button href="" class="btn btn-danger" style="border: none" @click="removeLine(index)"><span class="fa fa-trash"></span></button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="table-empty" colspan="2">
                <button class="table-add_line btn btn-primary" @click="addNewLine"><span class="fa fa-plus-circle"></span></button>
            </td>
            <td class="table-label">Sub Total</td>
            <td class="table-amount">{{subTotal}}</td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label">Discount</td>
            <td class="table-discount">
                <input type="text" class="table-discount_input form-control" v-model="info.discount">
            </td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label text-primary" style="font-weight: bold;">Grand Total</td>
            <td class="table-amount" style="font-weight: bold;">{{grandTotal}}</td>
        </tr>
    </tfoot>
 </table>
        <button class="btn btn-success" @click="createInvoice">Create</button>
        <router-link to="/invoices" class="btn btn-danger">Close</router-link>
 </div>

 </div>

 </div>
 
</template>

<script>
   export default{

        data(){

            return{
                items:[{

                    product_name:'',
                    price:'',
                    quantity:'',
                    line_total:''

                }],

                info:{},
                customer:{},
                showModal: false

            };

        },
        created(){
            //methods to be executed while this page is created

        },

        methods :{
            //fetch(){} //all memeber functions will be created here
            addNewLine(){
                this.items.push({
                    product_name:'',
                    price:'',
                    quantity: '',
                    line_total:''

                });

            }, // end of add new line
            removeLine(index){
                // this.invoices.remove();
                if(index!=0){
                   this.items.splice(index,1);
                }
                else{
                    alert('You can\'t delete this');
                }
                
               
            },//end of removeLine function

           calLineTotal(index){
            
               // alert(this.invoices[index].price);
               this.items[index].line_total=this.items[index].price * this.items[index].quantity;

            },
            createInvoice(){
                //Add
                this.info.status="Not Paid";
                if(this.info.discount==null){
                    this.info.discount=0;
                }

                    fetch('api/invoice',{
                        method: 'post',
                        body: JSON.stringify({'info':this.info,'items':this.items}),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res=>res.json())
                    .then(data=>{
                        alert('Invoice Added');
                        this.$router.push({ name: 'invoices'});
                    })
                    .catch(err=>console.log(err));
                    console.log();
            },
            addCustomer(){

                  fetch('api/customer/',{
                        method: 'post',
                        body: JSON.stringify({'customer':this.customer}),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res=>res.json())
                    .then(data=>{
                        alert('Customer Added');
                        this.customer.name='';
                        this.customer.address="";
                        this.customer.phone="";

                        
                    })
                    .catch(err=>console.log(err));
                    console.log();

                      this.$bvModal.hide('bv-modal-example')

            },

            autoComplete(){
                alert("hello");
            }

    },// end of methods

    computed:{

       subTotal: function() {
        //reduce function is used to sum the array elements
        this.info.subTotal= this.items.reduce(function(carry, item) {
        return carry + (parseFloat(item.quantity) * parseFloat(item.price));
              }, 0);
        return this.info.subTotal;

        },

       grandTotal: function() {
                
                if(this.info.discount!=null){
                    this.info.subTotal= this.subTotal - parseFloat(this.info.discount); 
                }
                else{
                    this.info.subTotal= this.subTotal - 0;
                }
               return this.info.subTotal;
        }
          

    },//end of computed

};//end of export default





</script>

