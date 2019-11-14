<template>
 <div>
     <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary" style="float: right;" @click="printInvoice(info.invoice_no)"><span class="fa fa-print"></span></button>
           </div>
            <div class="card-body" style="color: black;">
                <div id="printThisBlock">
                     <div class="company-Block" style="text-align: center;">
                <img class="comapny_logo_invoice" v-bind:src="settings.company_logo" alt="brand-logo-for-invoice" height="100px" width="100px">
                <h5>{{settings.company_name}}</h5>
                <p class="card-text">{{settings.company_address}}</p>
                <!-- <p class="card-text">{{settings.company_phone}}</p> -->
            </div>
 <div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Invoice No.</label>
            <span>{{info.invoice_no}}</span>
        </div>
        <div class="form-group">
            <label class="text-primary">Invoice To Customer</label>
            <br>
            <span style="font-weight: bold"> Name: </span>{{info.customer_name}}
            <br>
            <span style="font-weight: bold;color: black"> Address: </span>{{info.customer_address}}
            <br>
            <span style="font-weight: bold;color: black"> Phone: </span>{{info.customer_phone}}
        </div>

    </div>
    <div class="col-sm-5">
        
    </div>
    <div class="col-sm-3">
         <div style="text-align: right;">
         <span style="font-weight: bold"> Title: </span>
            {{info.title}}
        <br>
         <span style="font-weight: bold"> Inovie Date: </span>
            {{info.invoice_date}}
        <br>
         <span style="font-weight: bold"> Due Date: </span>
           {{info.due_date}}
    </div>
    </div>
</div>


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
             <td class="table-label">13% Tax</td>
            <td class="table-amount">{{info.taxAmount}}</td>
            
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label text-primary" style="font-weight: bold;">Grand Total</td>
            <td class="table-amount" style="font-weight: bold;">{{info.grand_total}}</td>
        </tr>
    </tfoot>
 </table>
        <p><b>Amount in Words </b>{{info.grand_total_words}}</p>
</div>
        <button class="btn btn-success" @click="editInvoice(id)">Edit</button>
        <router-link to="/invoices" class="btn btn-danger">Close</router-link>
 </div>

 </div>

 </div>
 
</template>
 <style>
.black{
    color: black;
    }
label{
     color: #000;
        font-weight: bold;
}
.company-Block{
/*border: 1px solid white;*/
margin-bottom: 10px;
text-align: center;
}
img.comapny_logo_invoice{
    width: 100px;
    height: 100px;
}



 </style>


<script>

    var converter = require('number-to-words');
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

                settings:{},
               
               

            };

        },
        created(){
           
            //methods to be executed while this page is created
            this.getIdFromUrl();
            this.fetchInvoice();
            this.fetchSettings();

        },
        mounted(){
           
        },
        methods :{

            getIdFromUrl(){

            this.id=this.$route.params.id;

        },//end of getIdFromUrl
           editInvoice(id){
          // named route
           this.$router.push({ path: `/${id}/editInvoice/` }) 
        },

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
                    Vue.set(this.info, 'discount', data.invoice.discount),
                    Vue.set(this.info, 'sub_total', data.invoice.sub_total),
                    Vue.set(this.info, 'taxAmount', data.invoice.tax_amount),
                    Vue.set(this.info, 'grand_total', data.invoice.grand_total),
                    Vue.set(this.info, 'customer_address', data.customer.address),
                    Vue.set(this.info, 'customer_phone', data.customer.phone),
                   
                    //veu.set will make data reactive and updated
                    this.items=data.invoice.invoice_detail,

                    //converting number to words
                    
                     this.info.grand_total_words=converter.toWords(this.info.grand_total)
                ));

        },//end of fetchInvoice
        printInvoice(id){

              // this.$router.push({ path: `/${id}/printInvoice/` })

              // let routeData = this.$router.resolve({name: 'printInvoice', query: {data: "someData"}});
              // window.open(routeData.href, '_blank');

              this.$htmlToPaper('printThisBlock');


        },
    fetchSettings(){

        fetch('api/settings/')
        .then(response=>response.json())
        .then(data=>(

               Vue.set(this.settings, 'id', data.settings.id),
              Vue.set(this.settings, 'company_name', data.settings.company_name),
              Vue.set(this.settings, 'company_email', data.settings.company_email),
              Vue.set(this.settings, 'company_address', data.settings.company_address),
              Vue.set(this.settings, 'company_phone', data.settings.company_phone),
              Vue.set(this.settings, 'company_url', data.settings.company_url),
              //company image
              Vue.set(this.settings, 'company_logo',"/img/"+ data.settings.company_logo),
              // this.company_logo="/img/"+data.settings.company_logo //concatenate image location and image name

              Vue.set(this.settings, 'vat', data.settings.vat)
              // console.log(data.settings.company_name)
          ));
      },//end of fetchSettings()

    },// end of methods

    computed:{

      
          

    },//end of computed

};//end of export default





</script>

