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
        <div class="form-group" style="position: relative;">
            <label>Customer</label>

            <input type="text" v-model="info.customer_name" v-on:keyup="autoComplete" class="form-control">

            <!-- Search suggestion block -->
           <div class="customer-search-suggestion">
               <div v-for="queryResult in queryResults" v-bind:key="queryResult.id" class="customer-search-suggestion-inner">
                 <ul>
                       <li  @click="clickSearchSuggestion(queryResult.id,queryResult.name)">{{queryResult.name}}</li>
                   </ul>
               </div>
           </div>
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
                    <!-- Search suggestion block ends -->

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
            <input type="text" v-model="info.title" class="form-control">
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Invoice Date</label>
                <date-picker v-model="info.invoice_date" value-type="format" format="YYYY-MM-DD">hello</date-picker>
            </div>
            <div class="col-sm-6">
                <label>Due Date</label>
                <date-picker v-model="info.due_date" value-type="format" format="YYYY-MM-DD"></date-picker>                
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
             <td class="table-label">13% Tax</td>
            <td class="table-amount">{{taxAmount}}</td>
            
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
<style>
.datetime-picker{

}
.datetime-picker input{
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}


.customer-search-suggestion {
    background: #f2f2f2;
    position: absolute;
    overflow-y: scroll;
    max-height: 9em;
    color: #000;
    border: 1px solid #e2dfdf;
    border-top: 0px;
    width: 100%;
   
}

.customer-search-suggestion-inner {
    padding: 1px;
    border-top: 1px solid #d6d6d6;
}
.customer-search-suggestion-inner ul{
    list-style: none;
    margin: 0;
    padding: 0;
}

.customer-search-suggestion-inner li {
    cursor: pointer;
    padding: 10px;

}
.customer-search-suggestion-inner li:hover{
    background: #007bff;
    color: #fff;
}


.customer-search-suggestion::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.customer-search-suggestion::-webkit-scrollbar
{
    width: 6px;
    background-color: #F5F5F5;
}

.customer-search-suggestion::-webkit-scrollbar-thumb
{
    background-color: #000000;
}


</style>

<script>

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

   export default{

  components: { DatePicker },

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
                showModal: false,
                queryResults:[],
                error:{
                    customer_name: false,
                    title:false,
                    invoice_date:false,
                    due_date:false
                }
              

            };

        },
        created(){
            //methods to be executed while this page is created
            //for validation initializing the varibles
            this.info.customer_name="";
            this.info.title="";
            this.info.due_date="";
            this.info.invoice_date="";
           

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
                    // alert('You can\'t delete this');
                      this.$toast.error({
                            title:'Opps!!',
                            message:'You can\'t delete this.'
                        });
                           
                }
                
               
            },//end of removeLine function

           calLineTotal(index){
            
               // alert(this.invoices[index].price);
               this.items[index].line_total=this.items[index].price * this.items[index].quantity;

            },
            createInvoice(){
              if(this.info.customer_name!="" &&this.info.title!="" &&this.info.invoice_date!="" &&this.info.due_date!=""){
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
                        // alert('Invoice Added');
                        // this.$toast.success({
                        //     title:'Invoice Added',
                        //     message:'Invoice Added Sucessfuly'
                        // });
                        //sweet alert
                        this.$swal('Good job!','You have created the Invoice!','success');
                        

                        this.$router.push({ name: 'invoices'});
                    })
                    .catch(err=>{
                            
                           this.displayToastMessage('Opps!!!','Something Happen');

                        });
                }
                else{

                    if(this.info.customer_name==""){ 
                        this.displayToastMessage('Error!!!','Customer Name can\'t be Empty');
                        // this.error.customer_name=true;
                    }
                    if(this.info.title==""){ 
                        this.displayToastMessage('Error!!!','Invoice Title can\'t be Empty');
                        // this.error.title=true;
                    }
                    if(this.info.invoice_date==""){
                        this.displayToastMessage('Error!!!','Invoice Date can\'t be Empty');
                        // this.error.invoice_date=true;
                    }
                    if(this.info.due_date==""){ 
                        this.displayToastMessage('Error!!!','Invoice Due Date can\'t be Empty');
                        // this.error.invoice_date=true;
                    }

                   
                }
                    
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

                if(this.info.customer_name===""){

                  this.queryResults=null;
                 
                }
                else{
                  
                    fetch('api/customer_search/',{
                        method: 'post',
                        body: JSON.stringify({'searchQuery':this.info.customer_name}),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res=>res.json())
                    .then(data=>{
                       
                       this.queryResults=data.queryResults;


                        
                    })
                    .catch(err=>console.log(err));
                    console.log();
                }
   
              
            },
            clickSearchSuggestion(customer_id,customer_name){

                    Vue.set(this.info, 'customer_id', customer_id);
                    Vue.set(this.info, 'customer_name', customer_name);
                    this.queryResults=null;
            },
            
            displayToastMessage(title,message){
                      this.$toast.error({
                            title: title,
                            message: message
                            });
            },

    },// end of methods

    computed:{
        //checks errors in the fields


       subTotal: function() {
        //reduce function is used to sum the array elements
        this.info.subTotal= this.items.reduce(function(carry, item) {
        return carry + (parseFloat(item.quantity) * parseFloat(item.price));
              }, 0);
        return this.info.subTotal;

        },

        taxAmount: function(){

            return this.subTotal*0.13;

        },
       grandTotal: function() {

                if(this.info.discount!=null){
                    return this.subTotal - parseFloat(this.info.discount) + this.taxAmount; 
                }
                else{
                    return this.subTotal+this.taxAmount;
                }
        }
          

    },//end of computed

};//end of export default





</script>

