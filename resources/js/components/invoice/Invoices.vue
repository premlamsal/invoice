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
                <h6 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Invoices</h6>
                      {{isLoading}}
              <div class="searchTable">
                       <!-- Topbar Search -->
                   <div class="input-group">
                      <input type="text" class="form-control border-primary small" placeholder="Search for Customer" aria-label="Search" aria-describedby="basic-addon2" v-model="searchTableKey">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="searchTableBtn">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered"  width="100%" cellspacing="0">
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

                      <td style="color: #fff;text-align: center;" v-if="(invoice.status==='Paid')">
                        <button class="btn btn-outline-success">
                        {{invoice.status}}
                         <span class="fa fa-check"></span>
                        </button>
                      </td>

                      <td style="color: #fff;text-align: center;" v-else-if="(invoice.status==='Not Paid')">
                        <button class="btn btn-outline-danger">
                        {{invoice.status}}
                        <span class="fa fa-times"></span>
                        </button>
                      </td>

                      <td>{{invoice.updated_at}}</td>
                      <td><button style="margin-right: 5px;" class="btn btn-outline-primary" @click="showInvoice(invoice.id)"><span class="fa fa-align-justify"></span></button><button class="btn btn-outline-success" @click="editInvoice(invoice.id)" style="margin-right: 5px;"><span class="fa fa-edit"></span></button><button class="btn btn-outline-danger" @click="deleteInvoice(invoice.id)"><span class="fa fa-trash"></span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-8">
                    <ul class="pagination">
                      <li class="page-item" v-bind:class="{disabled:!pagination.first_link}"><button @click="fetchInvoices(pagination.first_link)" class="page-link">First</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.prev_link}"><button @click="fetchInvoices(pagination.prev_link)" class="page-link">Previous</button></li>

                      <li v-for="n in pagination.last_page" v-bind:key="n" class="page-item" v-bind:class="{active:pagination.current_page == n}"><button @click="fetchInvoices(pagination.path_page + n)" class="page-link">{{n}}</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.next_link}"><button @click="fetchInvoices(pagination.next_link)" class="page-link">Next</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.last_link}"><button @click="fetchInvoices(pagination.last_link)" class="page-link">Last</button></li>
                    </ul>
                </div>
                <div class="col-md-4">
                  Page: {{pagination.current_page}}-{{pagination.last_page}}
                  Total Records: {{pagination.total_pages}}
                </div>
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
          searchTableKey:'',
          isLoading:'',
         
        };

      },

      created(){

        this.fetchInvoices();

      },

      methods:{

        fetchInvoices(page_url){
          this.isLoading="Loading all Data";
          page_url=page_url || '/api/invoices'
          let vm=this;
          fetch(page_url)
            .then(res=>res.json())
              .then(res=>{
                // console.log(res);
                this.invoices=res.data;
                this.isLoading="";
                if((this.invoices.length)!=null){
                   vm.makePagination(res.meta,res.links);
                }
                else{
                  
                }
               
              })
              .catch(err=>console.log(err));
        },
        makePagination(meta,links){
          let pagination={
            current_page : meta.current_page,
            last_page : meta.last_page,
            from_page : meta.from,
            to_page : meta.to,
            total_pages : meta.total,
            path_page : meta.path+"?page=",
            first_link : links.first,
            last_link : links.last,
            prev_link : links.prev,
            next_link : links.next
          
          }
          this.pagination=pagination;
        },

        deleteInvoice(id){

            this.$swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                //delete code here
                   fetch('api/invoice/'+id,{
                           method: 'delete'
                        })
                    .then(res=>res.json())
                    .then(data=>{
                        // alert('Invoice Removed');
                        this.$swal(
                                'Deleted!',
                                'Invoice has been deleted.',
                                'success'
                        );
                            
                        this.message="Invoice Removed";
                        this.fetchInvoices();
                      })
                    .catch(err=>console.log(err))

              }
            })

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


        }, 
        searchTableBtn(){
          this.autoCompleteTable();
        },
        autoCompleteTable(){

          this.searchTableKey=this.searchTableKey.toLowerCase();
          if(this.searchTableKey!=''){
              this.isLoading='Loading Data...';
               let currObj=this;
                axios.post('/api/invoices/search',{searchTableKey:this.searchTableKey})
                .then(function(response){

                  currObj.isLoading='';

                  currObj.invoices=response.data.data;
                   if(response.data.data==""){

                      currObj.isLoading="No Data Found";

                    }
                   // if((this.estimates.length)!=null){
                   // // currObj.makePagination(res.meta,res.links);
                   // }
                  // currObj.status=response.data.status;
                  currObj.errors = '';//clearing errors

                })
                .catch(function(error){
                   if (error.response.status == '422'){
                     currObj.validationErrors = error.response.data.errors;    
                     currObj.errors = currObj.validationErrors;
                      currObj.isLoading='Load Failed...';
                     // console.log(currObj.errors);

                    }
                });
          }  
          else{
            this.isLoading="Loading all Data";
            this.fetchInvoices();
          }  

        }//end of autoCOmpleteTable

      }//end of methods



    };//end of default
</script>