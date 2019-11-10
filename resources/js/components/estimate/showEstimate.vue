<template>
 <div>
     <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary" style="float: right;" @click="printEstimate(info.estimate_no)"><span class="fa fa-print"></span></button>
           </div>
            <div class="card-body" style="color: black;">
                <div id="printThisBlock">
 <div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Estimate No.</label>
            <span>{{info.estimate_no}}</span>
        </div>
        <div class="form-group">
            <label class="text-primary">Estimate To Customer</label>
            <br>
            <span style="font-weight: bold"> Name: </span>{{info.customer_name}}
            <br>
            <span style="font-weight: bold;color: black"> Address: </span>{{info.customer_address}}
            <br>
            <span style="font-weight: bold;color: black"> Phone: </span>{{info.customer_phone}}
        </div>

    </div>
    <div class="col-sm-5">
        <div class="form-group">
          <!--   <label>Customer Address</label>
            <textarea class="form-control" style="height: 7.6em" v-model="info.client_address"></textarea>
                
            -->
        </div>
    </div>
    
    <div class="col-sm-3">
         <div style="text-align: right;">
         <span style="font-weight: bold"> Title: </span>
            {{info.title}}
        <br>
         <span style="font-weight: bold"> Inovie Date: </span>
            {{info.estimate_date}}
        <br>
         <span style="font-weight: bold"> Due Date: </span>
           {{info.due_date}}
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
            
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item,index) in items">
            <td class="table-name">
                {{item.product_name}}
            </td>
            <td class="table-price">
                {{item.price}}
            </td>
            <td class="table-qty">
                {{item.quantity}}
            </td>
            <td class="table-total">
                <span class="table-text" v-model="item.line_total">{{item.quantity * item.price}}</span>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="table-empty" colspan="2">
                <!-- <button class="table-add_line btn btn-primary"><span class="fa fa-plus-circle"></span></button> -->
            </td>
            <td class="table-label">Sub Total</td>
            <td class="table-amount">{{info.sub_total}}</td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label">Discount</td>
            <td class="table-discount">
                {{info.discount}}
            </td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label text-primary" style="font-weight: bold;">Grand Total</td>
            <td class="table-amount" style="font-weight: bold;">{{info.grand_total}}</td>
        </tr>
    </tfoot>
 </table>
</div>
        <button class="btn btn-success" @click="editEstimate(id)">Edit</button>
        <router-link to="/estimates" class="btn btn-danger">Close</router-link>
 </div>

 </div>

 </div>
 
</template>
<style>
    black{
        color: black;
    }
</style>

<style type="text/css">
   label{
    color: #000;
   }
   table{color: #000!important;}

 </style>
 <style>
    label{
        color: #000;
        font-weight: bold;
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
            this.fetchEstimate();

        },
        mounted(){
           
        },
        methods :{

            getIdFromUrl(){

            this.id=this.$route.params.id;

        },//end of getIdFromUrl
           editEstimate(id){
          // named route
           this.$router.push({ path: `/${id}/editEstimate/` }) 
        },

        fetchEstimate(){

          fetch('api/estimate/'+this.id)
            .then(response => response.json())
            .then(data => (
                    
                    Vue.set(this.info, 'estimate_no', data.estimate.id),
                    Vue.set(this.info, 'title', data.estimate.title),
                    Vue.set(this.info, 'customer_id', data.estimate.customer_id),
                    Vue.set(this.info, 'customer_name', data.estimate.customer_name),
                    Vue.set(this.info, 'estimate_date', data.estimate.estimate_date),
                    Vue.set(this.info, 'due_date', data.estimate.due_date),
                    Vue.set(this.info, 'sub_total', data.estimate.sub_total),
                    Vue.set(this.info, 'grand_total', data.estimate.grand_total),
                    Vue.set(this.info, 'discount', data.estimate.discount),
                    Vue.set(this.info, 'customer_address', data.customer.address),
                    Vue.set(this.info, 'customer_phone', data.customer.phone),
                    //veu.set will make data reactive and updated
                    this.items=data.estimate.estimate_detail

                ));

        },//end of fetchEstimate
        printEstimate(id){

              this.$htmlToPaper('printThisBlock');


        }

    },// end of methods

    computed:{

      
          

    },//end of computed

};//end of export default





</script>

