<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Customer</h1>
          <p class="mb-4">
             <b-button id="show-btn" @click="showAddModal" class="btn btn-success" style="margin-top: 8px;">
                       <span class="fa fa-plus-circle"></span>
                     Add Customer</b-button>
          </p>

          <!-- add unit model start -->
                      <b-modal id="bv-modal-add-customer" hide-footer>
                        <template v-slot:modal-title>
                          {{modalForName}}
                        </template>
                        <div class="d-block">
                               <div class="form-group">
                                <input type="hidden" v-model="customer.id">
                                <label for="Name">Name:</label>
                               <!--  <input type="text"  v-model="customer.name" :class="['form-control', errors.name ? 'is-invalid' : '']"> -->
                               <input type="text"  v-model="customer.name" :class="['form-control']">
                                <span v-if="errors.name" :class="['errorText']">{{ errors.name[0] }}</span>
                              </div>
                              <div class="form-group">
                                <label for="Address">Address:</label>
                                <input type="text" v-model="customer.address" :class="['form-control']">
                                <span v-if="errors.address" :class="['errorText']">{{ errors.address[0] }}</span>
                              </div>
                               <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="phone" v-model="customer.phone" :class="['form-control']">
                                <span v-if="errors.phone" :class="['errorText']">{{ errors.phone[0] }}</span>
                               </div>
                            </div>
                        <b-button class="mt-3" block @click="callFunc">{{modalForName}}</b-button>
                      </b-modal>
            <!-- add unit modal end-->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Customers</h6>
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
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Updated at</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="customer in customers" v-bind:key="customer.id">
                      <td>{{customer.id}}</td>
                      <td>{{customer.name}}</td>
                      <td>{{customer.address}}</td>
                      <td>{{customer.phone}}</td>
                      <td>{{customer.updated_at}}</td>

                      <td><button class="btn btn-outline-success" style="margin-right: 5px;" @click=editCustomer(customer.id)><span class="fa fa-edit"></span></button><button class="btn btn-outline-danger" @click=deleteCustomer(customer.id)><span class="fa fa-trash"></span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-8">
                    <ul class="pagination">
                      <li class="page-item" v-bind:class="{disabled:!pagination.first_link}"><button @click="fetchCustomers(pagination.first_link)" class="page-link">First</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.prev_link}"><button @click="fetchCustomers(pagination.prev_link)" class="page-link">Previous</button></li>

                      <li v-for="n in pagination.last_page" v-bind:key="n" class="page-item" v-bind:class="{active:pagination.current_page == n}"><button @click="fetchCustomers(pagination.path_page + n)" class="page-link">{{n}}</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.next_link}"><button @click="fetchCustomers(pagination.next_link)" class="page-link">Next</button></li>

                      <li class="page-item" v-bind:class="{disabled:!pagination.last_link}"><button @click="fetchCustomers(pagination.last_link)" class="page-link">Last</button></li>
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

        customers:[], //contains all the retrived units from the database

        customer:{}, //for form single unit data

        modalForName: "",
        modalForCode: 0 , 

        searchTableKey:'',
        errors:[],
        pagination: {},

        isLoading:'',

      }
    },
    created(){
      //this block will execute when component created
      this.fetchCustomers();
    },

    methods:{
      //methods codes here
      fetchCustomers(page_url){

        let vm=this;// current pointer instance while going inside the another functional instance
        page_url=page_url || 'api/customers'
        axios.get(page_url)
        .then(function(response){
          vm.customers=response.data.data;
          if((vm.customers.length)!=null){
                vm.makePagination(response.data.meta,response.data.links);
              }
        })
        .catch(function(error){
          console.log();
        });

        //above and below code provide same result but above code need current instance pointer for value assignmnent 

         //below code donot need current pointer to be save becasue it execute in current block rather then another block that need previous pointer.


        // axios.get('/api/customers')
        // .then(response=>{
        //   // console.log(response.data.data)
        //   this.customers=response.data.data
        // })
        // .catch(error=>{
        //   console.log(error)
        // })


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
      showAddModal(){
        this.modalForName="Add Customer";
        // Vue.set(this.modalForName,"Add Unit");
        this.modalForCode=0; //0 for add 
        // Vue.set(this.modalForCode,0);
        this.$bvModal.show('bv-modal-add-customer')
      },
      callFunc(){

        if(this.modalForCode==0){
            this.addCustomer();
            // console.log("Add Unit");
        }
        else if(this.modalForCode==1){
            this.updateCustomer();
            // console.log("Edit Unit");
        }

      },
      addCustomer(){        
        let currObj=this;
        axios.post('/api/customer',this.customer)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          currObj.$swal('Info',currObj.output ,currObj.status);

          currObj.$bvModal.hide('bv-modal-add-customer');


          currObj.customer.name='';
          currObj.customer.address='';
          currObj.customer.phone='';

          currObj.errors = '';//clearing errors

          currObj.fetchCustomers();

        })
        .catch(function(error){
           if (error.response.status == 422){
             currObj.validationErrors = error.response.data.errors;    
             currObj.errors = currObj.validationErrors;
             // console.log(currObj.errors);
            }
        });



      },
      editCustomer(id){
        let currObj=this;
        this.modalForName="Edit Customer";
        this.modalForCode=1;// 1 for Edit
        this.$bvModal.show('bv-modal-add-customer');
        currObj.errors = '';//clearing errors
        axios.get('/api/customer/'+id)
        .then(response=>{
          // console.log(response.data.unit)
          Vue.set(this.customer, 'name', response.data.customer.name);
          Vue.set(this.customer, 'address', response.data.customer.address);
          Vue.set(this.customer, 'phone', response.data.customer.phone);
          Vue.set(this.customer, 'id', id);//to send id to the update controller 
        })
        .catch(error=>{
          console.log(error)
        })

      },
      updateCustomer(){

        let currObj=this;
        let formData= new FormData();
        formData.append('_method', 'PUT');//add this otherwise data won't pass to backend
        formData.append('name',this.customer.name);
        formData.append('address',this.customer.address);
        formData.append('phone',this.customer.phone);
        formData.append('id',this.customer.id);

        axios.post('/api/customer',formData)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          // alert(currObj.status);
           
                currObj.$swal('Info',currObj.output ,currObj.status);
                currObj.$bvModal.hide('bv-modal-add-customer');

                currObj.customer.name='';
                currObj.customer.address='';
                currObj.customer.phone='';
                currObj.errors = '';//clearing errors
                currObj.fetchCustomers();

        }).catch(function(error){
              if (error.response.status == 422){
             currObj.validationErrors = error.response.data.errors;    
             currObj.errors = currObj.validationErrors;
             // console.log(currObj.errors);
            }   
        })



      },
      deleteCustomer(id){
        let currObj=this;
          this.$swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result)=>{

              if(result.value){
                  axios.delete('/api/customer/'+id)
                  .then(function(response){
                     currObj.output=response.data.msg;
                      currObj.status=response.data.status;
                      // alert(currObj.status);
                      currObj.$swal('Info',currObj.output ,currObj.status);
                      currObj.fetchCustomers();

                  }).catch(function(error){
                     currObj.output=error;
                    console.log(currObj.output);
                  })

              }


          });


      },//end of deleteUnit()
      searchTableBtn(){
          this.autoCompleteTable();
        },
        autoCompleteTable(){

          this.searchTableKey=this.searchTableKey.toLowerCase();
          if(this.searchTableKey!=''){
              this.isLoading='Loading Data...';
               let currObj=this;
                axios.post('/api/customer_search',{searchQuery:this.searchTableKey})
                .then(function(response){

                  currObj.isLoading='';

                  currObj.customers=response.data.queryResults;
                   if(response.data.queryResults==""){

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
            this.fetchCustomers();
          }  

        }//end of autoCOmpleteTable



    //end of methods block
    }

  }
</script>
