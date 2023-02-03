<?php

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\RequisitionController;
// use Symfony\Component\Routing\Annotation\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/viewer', function () 
{
    return view('viewer');
});


Route::get('/share_vendor_contract', 'ContractController@share_with_vendor')->name('contract.share_vendor_contract');
Route::get('/vendor_view_contract/{contract}', 'ContractController@vendor_view_contract')->name('contract.vendor_view_contract');
Route::post('/vendor_validate', 'ContractController@vendor_validate')->name('contract.vendor_validate');
Route::post('/vendor_save_review', 'ContractController@save_vendor_review')->name('contract.vendor_save_review');
Route::get('/vendor_success', 'ContractController@vendor_success')->name('contracts.vendor_success');

Route::get('/soctest', 'HomeController@soctest')->name('viewer');
Route::post('/download', 'DocumentController@downloadFile')->name('download');
Route::post('/view', 'DocumentController@viewFile')->name('view');

//EXTERNAL / VENDOR USERS
Route::get('/vendor-login', 'Auth\External\LoginController@login')->name('show.login');
Route::post('/vendor-login', 'Auth\External\LoginController@loginExternal')->name('vendor.login');
Route::post('/logout-vendor', 'Auth\External\LoginController@logout_vendor')->name('logout-vendor');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('index');

//DASHBOARDS
Route::get('/statutory-dashboard', 'HomeController@statutoryDashboard')->name('statutory-dashboard')->middleware('auth');
Route::get('/task-dashboard', 'HomeController@taskDashboard')->name('task-dashboard')->middleware('auth');
Route::get('/contract-register-dashboard', 'HomeController@contractDashboard')->name('contract-register-dashboard')->middleware('auth');

//role routes
Route::resource('roles', 'RoleController');
Route::get('/get-role-by-id', 'RoleController@get_role_by_id');
Route::get('/users_api', 'RoleController@users_api')->name('users_api');



//documents routes
Route::get('/document_reviews', 'DocumentController@reviews')->name('documents.reviews');
Route::get('/my_pending_reviews', 'DocumentController@myPendingReviews')->name('documents.mypendingreviews');
Route::resource('documents', 'DocumentController', ['names' => ['create' => 'documents.create', 'index' => 'documents', 'store' => 'documents.save', 'show' => 'documents.view']]);

// user routes
Route::get('users/profile', 'UserController@profile')->name('users.profile');
Route::post('users/changepassword', 'UserController@changePassword')->name('users.changePassword');
Route::post('users/updateprofile', 'UserController@updateProfile')->name('users.updateProfile');
Route::get('users/alter-status', 'UserController@alterStatus')->name('users.alter-status')->middleware('superadmin');
Route::get('/download-user-excel-template', function () {  return Excel::download(new \App\Imports\UserImportTemplate, 'Employee Template.xlsx'); });
Route::get('/download-users-excel', function () {  return Excel::download(new \App\Exports\UserExport, 'Employees.xlsx'); });
Route::post('upload-user', 'UserController@upload_user')->name('upload-user')->middleware(['auth']);
Route::post('reset-user-password', 'UserController@reset_user_password')->name('reset-user-password')->middleware('auth');
Route::post('reset-password', 'UserController@reset_password')->name('reset-password');
Route::post('deactivate-account', 'UserController@deactivate_account')->name('deactivate-account');

Route::resource('users', 'UserController', ['names' => ['create' => 'users.create', 'index' => 'users', 'store' => 'users.save', 'edit' => 'users.edit', 'update' => 'users.update', 'show' => 'users.view']])->middleware('superadmin');
Route::post('assign-roles-to-user', 'UserController@addRolesToUser')->name('assign-roles-to-user');
Route::get('/get-user-by-id', 'UserController@get_user_by_id');
Route::get('/get-all-assigned-roles', 'UserController@get_all_assigned_roles');
Route::get('/get-user-roles', 'UserController@get_user_roles');
Route::get('/change-password', 'UserController@userChangePassword')->name('change-password')->middleware(['auth']);
Route::post('/save-change-password', 'UserController@saveChangePassword')->name('save-change-password')->middleware(['auth']);


//group routes
Route::resource('groups', 'GroupController', ['names' => ['create' => 'groups.create', 'index' => 'groups', 'store' => 'groups.save', 'edit' => 'groups.edit', 'update' => 'groups.update', 'show' => 'groups.view', 'destroy' => 'groups.delete']])->middleware('admin');
Route::get('folders/ajax', 'FolderController@ajax')->name('folders.ajax');
Route::resource('folders', 'FolderController', ['names' => ['create' => 'folders.create', 'index' => 'folders', 'store' => 'folders.save']]);
// workflows routes
Route::post('documents/savereview/{review_id}', 'DocumentController@storeReview')->name('documents.savereview');
Route::get('document_review/{id}', 'DocumentController@showReview')->name('documents.showreview');
Route::get('workflows/alter-status', 'WorkflowController@alterStatus')->name('workflows.alter-status')->middleware('admin');
Route::resource('workflows', 'WorkflowController', ['names' => ['create' => 'workflows.create', 'index' => 'workflows', 'store' => 'workflows.save', 'edit' => 'workflows.edit', 'update' => 'workflow.update', 'show' => 'workflows.view', 'destroy' => 'workflows.delete']])->middleware('admin');
//search-input
Route::get('search', 'DocumentController@search')->name('search');
//auditlog
//role routes
Route::get('auditlogs', 'AuditLogController@index')->name('auditlogs')->middleware('superadmin');
Route::get('auditlogs/{id}', 'AuditLogController@show')->name('auditlogs.view')->middleware('superadmin');
// Route::resource('audit_logs', 'AuditLogController',['names'=>['create'=>'auditlogs.new','index'=>'auditlogs']]);


Route::resource('template', 'TemplateController')->middleware('auth');
Route::get('contracts/new', 'ContractController@new')->name('contracts.new')->middleware('auth');
Route::get('contract_approvals', 'ContractController@ContractApproval')->name('contracts.reviews')->middleware('auth');
Route::get('approve_contract/{review_id}/{version_id?}', 'ContractController@reviewContract')->name('contracts.review')->middleware('auth');


//CONTRACT
Route::get('contracts/show/{id}/{version?}', 'ContractController@show')->name('contracts.show')->middleware('auth');
Route::get('contracts/create', 'ContractController@create')->name('contracts.create')->middleware('auth');
Route::post('contracts/add_comment', 'ContractController@addComment')->name('contracts.add_comment');
Route::get('contracts/delete_comment', 'ContractController@deleteComment')->name('contracts.delete_comment')->middleware('auth');
Route::get('contracts/download_approval_history/{contract_id}', 'ContractController@downloadContractApprovalHistory')->name('contracts.approval_history')->middleware('auth');
Route::get('contracts/download_version_history/{contract_id}', 'ContractController@downloadContractVersionHistory')->name('contracts.approval_history')->middleware('auth');
Route::get('contracts/final/{contract_id}', 'ContractController@downloadContractPDF')->name('contracts.final')->middleware('auth');
Route::get('contracts/dashboard', 'ContractController@dashboard')->name('contracts.dashboard')->middleware('auth');
Route::get('contracts/requisition', 'ContractController@new_requisition')->name('contracts.requisition')->middleware('auth');
Route::get('contracts/delete_requisition/{requisition_id}', 'ContractController@delete_requisition')->name('contracts.delete_requisition')->middleware('auth');
Route::get('contracts/requisitions', 'ContractController@requisitions')->name('contracts.requisitions')->middleware('auth');
Route::get('contracts/requisitions', 'ContractController@requisitions')->name('contracts.requisitions')->middleware('auth');
Route::get('contracts/user_requisitions', 'ContractController@user_requisitions')->name('contracts.user_requisitions')->middleware('auth');
Route::post('contracts/save_requisitions', 'ContractController@save_requisitions')->name('contracts.save_requisitions')->middleware('auth');
Route::get('/getRatingDetails', 'ContractController@getRatingDetails')->middleware('auth');
Route::get('/getManagerRatingDetails', 'ContractController@getManagerRatingDetails')->middleware('auth');
Route::get('/getMetricDetails', 'ContractController@getMetricDetails')->middleware('auth');
Route::get('/getLegalRatings', 'ContractController@getLegalRatings')->middleware('auth');
Route::get('/getManagerRatings', 'ContractController@getManagerRatings')->middleware('auth');
Route::get('/legalContractRatingsById', 'ContractController@legalContractRatingsById')->middleware('auth');
Route::get('/managerContractRatingsById', 'ContractController@managerContractRatingsById')->middleware('auth');
//CONTRACT TYPE
Route::resource("contract-type", 'ContractTypeController')->middleware('auth');;

//e-signature
Route::post('/save-signature', 'ContractController@saveSignature')->middleware('auth');
Route::get('/contract-table', 'ContractController@contractTable');


Route::resource('contracts', 'ContractController')->middleware('auth');

Route::get('download-as-word/{template}', 'TemplateController@downloadAsWord')->name('download.as.word')->middleware('auth');
Route::get('download_contract/{contract}', 'ContractController@downloadAsWord')->name('download.contract')->middleware('auth');
Route::resource('contract_categories', 'ContractCategoryController', ['names' => ['create' => 'contract_categories.create', 'index' => 'contract_categories', 'store' => 'contract_categories.save', 'edit' => 'contract_categories.edit', 'update' => 'contract_categories.update', 'show' => 'contract_categories.view', 'destroy' => 'contract_categories.delete']])->middleware('admin');









//PERFORMANCE METRIC
Route::get('performance/ratings', 'PerformanceMetricController@ratings')->name('performance.ratings')->middleware('auth');
Route::get('performance/vendors', 'PerformanceMetricController@vendors')->name('performance.vendors')->middleware('auth');
Route::resource('performance', 'PerformanceMetricController')->middleware('auth');
Route::get('/getPerformanceMetricDetials', 'PerformanceMetricController@getPerformanceMetricDetials')->middleware('auth');
Route::get('/setMetricDetials', 'MetricController@setMetricDetials')->middleware('auth');
// Route::post('/performance/disable','PerformanceMetricController@metricDisable')->middleware('auth');



Route::resource('quotation', 'QuotationController')->middleware('auth');

Route::get('purchase-order-template', 'PurchaseController@template')->name('purchase-template')->middleware('auth');
Route::post('store-template', 'PurchaseController@storeTemplate')->name('store-template')->middleware('auth');
Route::get('getPurchaseOrderTemplate', 'PurchaseController@getPurchaseOrderTemplate')->middleware('auth');
Route::get('purchase-order-create/{id}', 'PurchaseController@create_purchase_order')->name('purchase-order-create')->middleware('auth');
Route::get('purchase-order-edit/{id}', 'PurchaseController@editTemplate')->name('purchase-order-edit')->middleware('auth');
Route::get('getPurchaseOrderVersion', 'PurchaseController@getPurchaseOrderVersion')->middleware('auth');
Route::get('purchase-order-search', 'PurchaseController@create_purchase_search')->name('purchase-order-search')->middleware('auth');
Route::get('purchase-order-view/{id}', 'PurchaseController@purchase_order_view')->name('purchase-order-view')->middleware('auth');
Route::post('store-comment', 'PurchaseController@storeComment')->name('store-comment')->middleware('auth');
Route::get('getComments', 'PurchaseController@getComments')->middleware('auth');
Route::post('remove-comment', 'PurchaseController@removeComment')->name('remove-comment')->middleware('auth');

Route::get('purchase-order-requisition', 'PurchaseController@requisition')->name('purchase-order-requisition')->middleware('auth');
Route::post('purchase-order-requisition-store', 'PurchaseController@requisition_store')->name('purchase-order-requisition-store')->middleware('auth');
Route::get('fetchRequisitionDetails', 'PurchaseController@fetchRequisitionDetails')->middleware('auth');
Route::resource('purchase-order', 'PurchaseController')->middleware('auth');





//WORKORDER
Route::get('workorder', 'WorkorderController@index')->name('workorder')->middleware('auth');
Route::get('work-order-requisition', 'WorkorderController@index')->name('work-order-requisition')->middleware('auth');
Route::post('work-order-requisition-store', 'PurchaseController@requisition_store')->name('work-order-requisition-store')->middleware('auth');

Route::resource('workorder', 'WorkorderController')->middleware('auth');


//COMPLETION
Route::resource('completion', 'CompletionController')->middleware('auth');













//DEPARTMENT
Route::get('/departments', 'AdminController@departments')->name('departments');
Route::post('/departments/store', 'AdminController@addDepartment')->name('departments.store');
Route::get('/get-department-by-id', 'AdminController@get_department_by_id');
Route::post('/delete-department', 'AdminController@delete_department');


Route::get('/assign-tasks', 'AdminController@assignTask')->name('assign-tasks')->middleware('auth');
Route::post('/add-assign-task', 'AdminController@addAssignTask')->name('add-assign-task')->middleware('auth');
Route::get('/get-assign-by-id', 'AdminController@get_assign_by_id');
Route::post('/delete-assign', 'AdminController@delete_assign');


Route::get('/delegate-role', 'AdminController@delegateRole')->name('delegate-role')->middleware('auth');
Route::post('/add-delegate-role', 'AdminController@addDelegateRole')->name('add-delegate-role')->middleware('auth');
Route::get('/get-delegate-by-id', 'AdminController@get_delegate_by_id');
Route::post('/delete-delegate', 'AdminController@delete_delegate');

//DEPARTMENT
Route::get('/messages', 'AdminController@emailMessages')->name('messages');
Route::post('/messages/store', 'AdminController@addMessage')->name('messages.store');
Route::get('/get-message-by-id', 'AdminController@get_message_by_id');
Route::post('/delete-message', 'AdminController@delete_message');





//TASK REQUEST
Route::get('request-externals', 'TaskRequestController@request_externals')->name('request-externals');
Route::post('store-external-requests', 'TaskRequestController@requests_store')->name('store-external-requests');

Route::get('/get-request-by-id', 'TaskRequestController@get_request_by_id');
Route::post('/approve-request', 'TaskRequestController@approve_request');
Route::post('/delete-request', 'TaskRequestController@delete_request');
Route::get('/request-detail/{id}', 'TaskRequestController@request_detail')->name('request-detail');
Route::get('/download-request-excel', function () {  return Excel::download(new \App\Exports\RequestExport, 'Requests.xlsx'); });
Route::resource('requests', 'TaskRequestController')->middleware('auth');


//REQUISITIONS
Route::resource('requisitions', 'RequisitionController')->middleware('auth');
Route::get('/get-requisition-by-id', 'RequisitionController@get_requisition_by_id');
Route::post('/delete-requisition', 'RequisitionController@delete_requisition');
Route::post('/upload-executed-copy', 'RequisitionController@uploadExecutedCopy')->name('upload-executed-copy')->middleware('auth');
Route::get('/task-detail/{id}', 'RequisitionController@task_detail')->name('task-detail');
Route::get('/download-requisition-excel', function () {  return Excel::download(new \App\Exports\RequisitionExport, 'Requisitions.xlsx'); });



//ASSIGNMENT
Route::get('/requisition-clarity/{id}', 'AssignmentController@ShowRequisitionClarity')->name('requisition-clarity');
Route::post('/requisition-clarity', 'AssignmentController@RequisitionClarity')->name('requisition-clarity');
Route::post('/requisition-clarity-response', 'AssignmentController@RequisitionClarityResponse')->name('requisition-clarity-response');
Route::post('/clarity-endded', 'AssignmentController@clarityEnded')->name('clarity-endded');
Route::get('/get-requirement&filings-by-id', 'AssignmentController@get_assignment_by_id');
Route::get('/user-tasks', 'AssignmentController@userTasks')->name('user-tasks');
Route::post('/delete-assignment', 'AssignmentController@delete_assignment');
// Route::post('/update-contract-type', 'AssignmentController@update_contract_type');
Route::resource('assignments', 'AssignmentController')->middleware('auth');



//DOCUMENT CREATION
Route::get('/new-document/{id}', 'DocumentCreationController@NewDocument')->name('new-document');
Route::get('/create-document/{id}/{temp}', 'DocumentCreationController@createDocument')->name('create-document');
Route::get('/all-document', 'DocumentCreationController@allDocuments')->name('all-documents');
Route::get('/user-documents', 'DocumentCreationController@userDocuments')->name('user-documents');
Route::get('/get-prefered-template/{id}', 'DocumentCreationController@getPreferedTemplateById');
Route::get('/get-prefered-template', 'DocumentCreationController@getPreferedTemplate');
Route::get('/view-document/{id}', 'DocumentCreationController@viewDocument')->name('view-document');
Route::post('/delete-document-creation', 'DocumentCreationController@delete_document_creation');
Route::post('/document-review-comment', 'DocumentCreationController@reviewsAndComments')->name('document-review-comment');
Route::post('/share-link-url', 'DocumentCreationController@shareLinkUrl')->name('share-link-url');
Route::post('/review-document', 'DocumentCreationController@reviewDocument')->name('review-document');
Route::post('/push-for-approval', 'DocumentCreationController@pushForApproval')->name('push-for-approval');
Route::post('/approve-document', 'DocumentCreationController@approveDocument')->name('approve-document');
Route::post('/decline-document', 'DocumentCreationController@declineDocument')->name('decline-document');
Route::post('sign-signature', 'DocumentCreationController@signSignature')->name('save-signature');
Route::post('upload-signature', 'DocumentCreationController@uploadSignature')->name('upload-signature');
Route::get('/document-link-url', 'DocumentCreationController@documentLinkUrl')->name('document-link-url');
Route::get('/test-document', 'DocumentCreationController@testdocument')->name('test-document');

Route::post('/store-template', 'DocumentCreationController@storeDocument')->name('store-template');
Route::get('/pending-reviews', 'DocumentCreationController@pending_reviews')->name('pending-reviews');
Route::get('/pending-approvals', 'DocumentCreationController@pending_reviews')->name('pending-approvals');
Route::get('/prefered-tamplates', 'DocumentCreationController@preferedTemplate')->name('prefered-tamplates');
Route::get('/create-prefered-template', 'DocumentCreationController@CreatePreferedTemplate')->name('create-prefered-template');
Route::post('/store-prefered-template', 'DocumentCreationController@StorePreferedTemplate')->name('store-prefered-template');
Route::get('/prefered-tamplate-view/{id}', 'DocumentCreationController@preferedTemplateView')->name('prefered-tamplate-view');
Route::get('/get-template-by-id', 'DocumentCreationController@get_template_by_id');
Route::get('/document-details/{id}', 'DocumentCreationController@document_details')->name('document-details');
Route::get('/download-document-excel', function () {  return Excel::download(new \App\Exports\DocumentExport, 'Contract & Contracts.xlsx'); });

Route::resource('document-creations', 'DocumentCreationController')->middleware('auth');



//Requirement and Fillings
Route::get('/calendar', 'RequirementAndFilingController@calendar')->name('calendar');
Route::post('/action', 'RequirementAndFilingController@action')->name('action');
Route::get('/getEventData', 'RequirementAndFilingController@getEventData');
Route::post('delete', 'RequirementAndFilingController@delete')->name('delete')->middleware('auth');
Route::resource('requirements-and-filings', 'RequirementAndFilingController')->middleware('auth');
Route::get('/get-requirement-and-filings-by-id', 'RequirementAndFilingController@get_requirement_filings_by_id');

Route::get('/download-requirementfiling-excel-template', function () {  return Excel::download(new \App\Imports\RequirementFilingTemplate, 'Requirements & Filings Template.xlsx'); });
Route::get('/download-requirementfilings-excel', function () {  return Excel::download(new \App\Exports\RequirementFilingExport, 'Requirements & Filings.xlsx'); });
Route::post('upload-requirementfiling', 'RequirementAndFilingController@upload_requirementfiling')->name('upload-requirementfiling')->middleware(['auth']);


Route::get('downloadWord', 'DocumentCreationController@downloadWord');
Route::get('/convertToDoc', 'ProposalController@convertToDoc')->name('convertToDoc');





//VENDOR
Route::get('/getVendorDetails', 'VendorController@getVendorDetails')->middleware('auth');
Route::get('vendor-registration/', 'VendorController@vendor_registration')->name('vendor-registration');
Route::get('vendor-shortlist/{id}', 'VendorController@vendor_shortlist')->name('vendor-shortlist')->middleware('auth');
Route::post('upload-vendor', 'VendorController@upload_vendor')->name('upload-vendor')->middleware('auth');
Route::get('download_template', 'VendorController@download_template')->name('download_template');
Route::get('/getVendorShortlists', 'VendorController@getVendorShortlists')->middleware('auth');
Route::post('shortlist-vendor', 'VendorController@shortlist_vendor')->name('shortlist-vendor')->middleware('auth');
Route::get('shortlisted-vendor/{id}', 'VendorController@shortlisted_vendor')->name('shortlisted-vendor')->middleware('auth');
Route::post('upload-document', 'VendorController@upload_document')->name('upload-document')->middleware('auth');
Route::post('approve-vendor', 'VendorController@approve_vendor')->name('approve-vendor')->middleware('auth');
Route::post('update-company-info', 'VendorController@update_company_info')->name('update-company-info')->middleware('auth');

Route::get('vendor-profile/{id}', 'VendorController@vendor_profile')->name('vendor-profile')->middleware('auth');
Route::get('/get-doc_type-by-id', 'VendorController@get_doc_type_by_id');
Route::get('/load-document-table', 'VendorController@load_document_table');
Route::post('delete-document', 'VendorController@delete_document')->name('delete-document')->middleware('auth');
Route::get('/get-submitted-bid-documents', 'VendorController@get_submitted_bid_documents');
Route::get('/get-submitted-bid-docs', 'VendorController@get_submitted_bid_docs');
Route::get('/load-bid-documents', 'VendorController@load_bid_documents');

Route::get('/download-vendor-excel', function () {
    return Excel::download(new \App\Exports\VendorExport, 'vendors.xlsx');
});
Route::get('/download-vendor-excel-template', function () {
    return Excel::download(new \App\Exports\VendorExportTemplate, 'vendorTemplate.xlsx');
});

Route::resource('vendor', 'VendorController');

Route::get('/vendor-home', 'VendorHomeController@vendor_home')->name('vendor-home');



//SYNCING PALIPRO WITH BC API
Route::get('/getAllVendors', 'VendorController@getAllVendors');
Route::get('/getAllVendorIdNames', 'VendorController@getAllVendorIdNames');








//BID
Route::get('/getBidDetails', 'BidController@getBidDetails')->middleware('auth');
Route::post('/upload-bid', 'BidController@upload_bid')->name('upload-bid')->middleware('auth');
Route::get('/download-bid-excel', 'BidController@download_bid_excel')->name('download-bid-excel')->middleware('auth');
Route::get('/download-bid-excel', function () {
    return Excel::download(new \App\Exports\BidExport, 'bids.xlsx');
});
Route::get('/download-bid-excel-template', function () {
    return Excel::download(new \App\Exports\BidExportTemplate, 'bidTemplate.xlsx');
});

Route::get('/bid-packages/{id}', 'BidController@bid_packages')->name('bid-packages')->middleware('auth');
Route::post('/add-bid-email-list', 'BidController@add_bid_email_list')->name('add-bid-email-list')->middleware('auth');
Route::post('/upload-bid-attachment', 'BidController@upload_bid_attachment')->name('upload-bid-attachment')->middleware('auth');
Route::get('/load-bid-document-table', 'BidController@load_bid_document_table');
Route::get('/load-email-list-table', 'BidController@load_email_list_table');
Route::get('/get-bid-document-by-id', 'BidController@getBidDocumentDetails');
Route::get('/get-email-list-by-id', 'BidController@getBidEmailListDetails');
Route::post('/delete-email-list', 'BidController@delete_email_list')->name('delete-email-list')->middleware('auth');
Route::post('/delete-bid-document', 'BidController@delete_bid_document')->name('delete-bid-document')->middleware('auth');

Route::get('/search-for-bidders/{id}', 'BidController@search_for_bidders')->name('search-for-bidders')->middleware('auth');
Route::get('/list-search-bidders', 'BidController@list_search_bidders')->name('list-search-bidders')->middleware('auth');
Route::post('/shortlist-one-vendor', 'BidController@shortlist_one_vendor')->name('shortlist-one-vendor')->middleware('auth');
Route::post('/shortlist-all-vendors', 'BidController@shortlist_all_vendors')->name('shortlist-all-vendors')->middleware('auth');
Route::post('/remove-one-vendor', 'BidController@remove_one_vendor')->name('remove-one-vendor')->middleware('auth');
Route::post('/remove-all-vendors', 'BidController@remove_all_vendors')->name('remove-all-vendors')->middleware('auth');
Route::get('/getShortlistedVendors', 'BidController@getShortlistedVendors');
Route::get('/load-bidders-table', 'BidController@load_bidders_table');
Route::post('/bid-message', 'BidController@bid_message')->name('bid-message')->middleware('auth');
Route::post('/invite-vendors-to-bid', 'BidController@invite_vendors_to_bid')->name('invite-vendors-to-bid')->middleware('auth');
Route::get('/bid-invitation/{id}', 'BidController@bid_invitation')->name('bid-invitation')->middleware('auth');
Route::get('/submitted-bids', 'BidController@submitted_bids')->name('submitted-bids')->middleware('auth');

Route::resource('bids', 'BidController')->middleware('auth');







//VENDOR BID
Route::get('profile', 'VendorBidController@profile')->name('profile')->middleware('auth:vendor');
Route::post('upload-document-vendor', 'VendorBidController@upload_document_vendor')->name('upload-document-vendor')->middleware('auth:vendor');
Route::get('/load-vendor-doc-table', 'VendorBidController@load_vendor_doc_table');
Route::post('delete-vendor-doc', 'VendorBidController@delete_vendor_doc')->name('delete-vendor-doc')->middleware('auth:vendor');

Route::get('/submit-bids', 'VendorBidController@submit_bids')->name('submit-bids')->middleware('auth:vendor');
Route::get('/bid-submissions/{id}', 'VendorBidController@bid_submissions')->name('bid-submissions')->middleware('auth:vendor');
Route::post('/respond-to-bid', 'VendorBidController@respond_to_bid')->name('respond-to-bid')->middleware('auth:vendor');
Route::post('/remove-submitted-bid-attachment', 'VendorBidController@removeBidAttachment')->name('remove-submitted-bid-attachment')->middleware('auth:vendor');

Route::get('/checkSubmittedBid', 'VendorBidController@checkSubmittedBid');
Route::get('/getSubmittedBidDetail', 'VendorBidController@getSubmittedBidDetail')->middleware('auth:vendor');
Route::get('/getSubmittedBidAttachments', 'VendorBidController@getSubmittedBidAttachments')->middleware('auth:vendor');
Route::get('/get-document-by-id', 'VendorBidController@get_document_by_id')->middleware('auth:vendor');

Route::get('reset-password-view', 'VendorBidController@reset_password_view')->name('reset-password-view')->middleware('auth:vendor');
Route::post('reset-vendor-password', 'VendorBidController@reset_vendor_password')->name('reset-vendor-password')->middleware('auth:vendor');

Route::post('update-about-company', 'VendorBidController@update_about_company')->name('update-about-company')->middleware('auth:vendor');
Route::resource('vendor-bids', 'VendorBidController')->middleware('auth:vendor');




Route::get('sign', 'HomeController@sign')->name('sign');



Route::get('/testword', 'DocumentCreationController@testword');


Route::get('/google-react/{id}', 'DocumentCreationController@googleReact')->name('google-react');
Route::get('/google-react-edit/{id}', 'DocumentCreationController@googleReactEdit')->name('google-react-edit');
Route::get('/get-task-by-id/{id}', 'DocumentCreationController@getTaskById')->name('get-task-by-id');
Route::get('/get-task-google-id/{id}', 'DocumentCreationController@getTaskGoogleId')->name('get-task-google-id');
Route::post('update-documentid', 'DocumentCreationController@updateDocumentId')->name('update-documentid')->middleware('auth');



//EXCEL VENDOR UPLOAD
Route::get('upload-vendors', 'VendorBidController@uploadVendors')->name('upload-vendors');
Route::post('upload-vendor-store', 'VendorBidController@uploadVendorStore')->name('upload-vendor-store');



Route::get('/test-email', 'AssignmentController@testEmail')->name('test-email')->middleware('auth');



//SUPPORT 
//ROUTE FOR HANDSHAKE INTO PALIPRO
// Route::get('/PaliproAARlogin', function(Request $request)
// {
//     $user=\App\User::updateOrCreate(['email'=>$request->email], ['email'=>$request->email, 'password'=>bcrypt('peace133'), 'name'=>'Users']);
//     \Auth::loginUsingId($user->id);
//     return redirect('/home');
// });




//
Route::get('log_hcm_user/{email}/{key}', function ($email, $key) {
    if ($key == env("HCM_APP_KEY")) {
        $user = App\User::where('email', $email)->first();
        if ($user) {
            Auth::loginUsingId($user->id);
        } else {

            $user = new App\User();
            $user->name = 'Kel';
            $user->email = $email;
            $user->role_id = 1;
            $user->department_id = 1;
            $user->password = bcrypt('qwerty!@#');
            $user->save();

            Auth::loginUsingId($user->id);
        }
        return redirect()->route('home');
    }
});


// Requests

Route::get('/requestForm', [RequisitionController::class, 'requestForm'])->name('requestForm');
Route::post('/saveRequest', [RequisitionController::class, 'storeRequest'])->name('saveRequest');
