<template>
 <div>
     <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-primary">Edit Invoice</h5>
            </div>
            <div class="card-body">
 <div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Status</label>
            <template v-if="(info.status==='Paid')">
               <select class="form-control" v-model="info.status">
                <option selected="" style="background: green;color: #fff">Paid</option>       
                <option style="background: red;color: #fff">Not Paid</option>
               </select>
            </template>
           
              <template v-else-if="(info.status==='Not Paid')">
               <select class="form-control" v-model="info.status">
                <option selected="" style="background: red;color: #fff">Not Paid</option>       
                <option style="background: green;color: #fff">Paid</option>
               </select>
            </template>
            <br>
            <label>Invoice No.</label>
            <input type="text" class="form-control" disabled="" v-model="info.invoice_no">
            
        </div>
        <div class="form-group">
            <label>Customer</label>
            <input type="text" class="form-control" v-model="info.customer_name">
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
        <button class="btn btn-success" @click="updateInvoice">Update</button>
        <router-link to="/invoices" class="btn btn-danger">Close</router-link>
 </div>

 </div>

 </div>
 
</template>

<style type="text/css">
   label{
    color: #000;
   }
   table{color: #000!important;}

 </style>
 <style>
 	label{
 		color: #000;
 	}
 </style>

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
                id:'',
               
               

            };

        },
        created(){
           
            //methods to be executed while this page is created
            this.getIdFromUrl();
            this.fetchInvoice();

        },
        mounted(){
           
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
            updateInvoice(){

                if(this.info.discount==null){
                    this.info.discount=0;
                }

                    fetch('api/invoice',{
                        method: 'put',
                        body: JSON.stringify({'info':this.info,'items':this.items,'id':this.id}),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res=>res.json())
                    .then(data=>{
                        // alert('Invoice Updated');
                        //for toast message
                        //  this.$toast.warn({
                        //     title:'Invoice Updated',
                        //     message:'Invoice Updated Sucessfully'
                        // });

                        //sweet alert
                        this.$swal('Good job!','You have updated the Invoice!','success');
                        	
                         this.$router.push({ name: 'invoices'});

                    })
                    .catch(err=>console.log(err));
                    console.log();
            },

            getIdFromUrl(){

      		this.id=this.$route.params.id;

      	},//end of getIdFromUrl

      	fetchInvoice(){

          fetch('api/invoice/'+this.id)
            .then(response => response.json())
            .then(data => (
            		
            		Vue.set(this.info, 'invoice_no', data.invoice.id),
            		Vue.set(this.info, 'title', data.invoice.title),
            		Vue.set(this.info, 'customer_id', data.invoice.customer_id),
            		Vue.set(this.info, 'customer_name', data.invoice.customer_name),
            		Vue.set(this.info, 'invoice_date', data.invoice.invoice_date),
            		Vue.set(this.info, 'due_date', data.invoice.due_date),
                    Vue.set(this.info, 'status', data.invoice.status),
            		//veu.set will make data reactive and updated
            		this.items=data.invoice.invoice_detail
            	));

      	}//enf od fetchInvoice

    },// end of methods

    computed:{

       subTotal: function() {
        //reduce function is used to sum the array elements
        this.info.subTotal= this.items.reduce(function(carry, item) {
        return carry + (parseFloat(item.quantity) * parseFloat(item.price));
              }, 0);
        return this.info.subTotal;

        },
        setInvoiceVars: function(){

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

