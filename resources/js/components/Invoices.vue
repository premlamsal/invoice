<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Invoices</h1>
          <p class="mb-4">
            <router-link class="btn btn-primary" to="/newInvoice">New Invoice</router-link>
          </p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Invoices</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Invoice No.</th>
                      <th>Grand Total</th>
                      <th>Client</th>
                      <th>Invoice Date</th>
                      <th>Due Date</th>
                      <th>Status</th>
                      <th>Last Modified at</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                 <!--  <tfoot>
                    <tr>
                      <th>Invoice No.</th>
                      <th>Grand Total</th>
                      <th>Client</th>
                      <th>Invoice Date</th>
                      <th>Due Date</th>
                      <th>Created At</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                    <tr v-for="invoice in invoices" v-bind:key="invoice.id">
                      <td>{{invoice.id}}</td>
                      <td>Rs. {{invoice.grand_total}}</td>
                      <td>{{invoice.customer_name}}</td>
                      <td>{{invoice.invoice_date}}</td>
                      <td>{{invoice.due_date}}</td>

                      <td style="color: #fff" v-if="(invoice.status==='Paid')" class="bg-success">{{invoice.status}}</td>

                      <td style="color: #fff;" v-else-if="(invoice.status==='Not Paid')" class="bg-danger">{{invoice.status}}</td>

                      <td>{{invoice.updated_at}}</td>
                      <td><button style="margin-right: 5px;" class="btn btn-primary" @click="showInvoice(invoice.id)"><span class="fa fa-align-justify"></span></button><button class="btn btn-success" @click="editInvoice(invoice.id)" style="margin-right: 5px;"><span class="fa fa-edit"></span></button><button class="btn btn-danger" @click="deleteInvoice(invoice.id)"><span class="fa fa-trash"></span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
 </div>
</template>
<script>
  export default{

   data(){
        return {
          invoices : [],
          invoice_id:'',
          pagination: {},
          edit: false,
         
        };

      },

      created(){

        this.fetchInvoices();

      },

      methods:{

        fetchInvoices(page_url){
          page_url=page_url || '/api/invoices'
          let vm=this;
          fetch(page_url)
            .then(res=>res.json())
              .then(res=>{
                // console.log(res);
                this.invoices=res.data;
                vm.makePagination(res.meta,res.links);
              })
              .catch(err=>console.log(err));
        },
        makePagination(meta,links){
          let pagination={
            current_page : meta.current_page,
            last_page : meta.last_page,
            next_page_url : links.next,
            prev_page_url : links.prev
          }
          this.pagination=pagination;
        },

        deleteInvoice(id){
          if(confirm('Are You sure ?')){

            fetch('api/invoice/'+id,{
              method: 'delete'
            })
            .then(res=>res.json())
            .then(data=>{
              alert('Invoice Removed');
              
              this.message="Invoice Removed";
              this.fetchInvoices();
            })
            .catch(err=>console.log(err))

          }

        },
        editInvoice(id){
          // named route
          // this.$router.push({ name: 'editInvoice', params: { id } });
            this.$router.push({ path: `${id}/editInvoice/` }) 
        },
        showInvoice(id){
          // named route

          // this.$router.push({ name: 'showInvoice', params: { id } }); //will hide parameter in url


          this.$router.push({ path: `${id}/showInvoice/` }) 


        }

      }//end of methods



    };//end of default
</script>