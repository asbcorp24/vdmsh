<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,SchoolController,EducationController,DocumentsController,NewsController,EventController,PageController as PublicPage,AchievementController,CreativeController,CollectiveController,CompetitionController,ScheduleController,TeacherController as PublicTeacher,ContactController,DepartmentController as PublicDepartment,ProgramController as PublicProgram,SearchController,AdmissionController,FeedbackController,DownloadController,GalleryController,MusicLibraryController,ChoreographyController,StudentController};
use App\Http\Controllers\Admin\{DepartmentController as AdminDepartment,TeacherController as AdminTeacher,ProgramController as AdminProgram,DocumentController as AdminDocument,PageController as AdminPage,MediaController as AdminMedia,CollectiveController as AdminCollective,CompetitionController as AdminCompetition,GalleryController as AdminGallery,MenuController as AdminMenu,ScheduleController as AdminSchedule,SettingController as AdminSetting,AchievementController as AdminAchievement,AuthController as AdminAuth,DashboardController as AdminDashboard,NewsController as AdminNews,EventController as AdminEvent,EventPerformanceController as AdminEventPerformance,AdmissionCampaignController as AdminAdmission,FeedbackController as AdminFeedback,UserController as AdminUser,StudentController as AdminStudent,HomePageController as AdminHomePage,MusicController as AdminMusic,MusicLibraryController as AdminMusicLibrary};

Route::get('/',HomeController::class)->name('home');
Route::get('/school',[SchoolController::class,'index'])->name('school');
Route::get('/education',EducationController::class)->name('education');
Route::get('/admission',AdmissionController::class)->name('admission');
Route::get('/events',[EventController::class,'index'])->name('events');
Route::get('/events/{event:slug}',[EventController::class,'show'])->name('events.show');
Route::get('/news',[NewsController::class,'index'])->name('news');
Route::get('/news/{news:slug}',[NewsController::class,'show'])->name('news.show');
Route::get('/documents',DocumentsController::class)->name('documents');
Route::get('/documents/{page:slug}',[DocumentsController::class,'show'])->name('documents.show');
Route::get('/contacts',ContactController::class)->name('contacts');
Route::get('/achievements',AchievementController::class)->name('achievements');
Route::get('/gallery',[GalleryController::class,'index'])->name('gallery');
Route::get('/gallery/{gallery:slug}',[GalleryController::class,'show'])->name('gallery.show');
Route::view('/methodical','methodical.index')->name('methodical');
Route::get('/collectives',CollectiveController::class)->name('collectives');
Route::get('/competitions',[CompetitionController::class,'index'])->name('competitions');
Route::get('/competitions/{competition:slug}',[CompetitionController::class,'show'])->name('competitions.show');
Route::get('/creative',CreativeController::class)->name('creative');
Route::get('/schedule',ScheduleController::class)->name('schedule');
Route::get('/search',SearchController::class)->name('search');
Route::get('/feedback',[FeedbackController::class,'create'])->name('feedback');
Route::post('/feedback',[FeedbackController::class,'store'])->middleware('throttle:5,10')->name('feedback.store');
Route::get('/programs',[PublicProgram::class,'index'])->name('programs.index');
Route::get('/programs/{program}',[PublicProgram::class,'show'])->name('programs.show');
Route::get('/departments',[PublicDepartment::class,'index'])->name('departments.index');
Route::get('/departments/{department}',[PublicDepartment::class,'show'])->name('departments.show');
Route::get('/teachers',[PublicTeacher::class,'index'])->name('teachers.index');
Route::get('/teachers/{teacher}',[PublicTeacher::class,'show'])->name('teachers.show');
Route::get('/students',[StudentController::class,'index'])->name('students.index');
Route::get('/students/{student}',[StudentController::class,'show'])->name('students.show');
Route::get('/download/{path}',DownloadController::class)->where('path','.*')->name('download');
Route::get('/p/{page:slug}',[PublicPage::class,'show'])->name('page.show');

Route::middleware('guest')->group(function(){Route::get('/admin/login',[AdminAuth::class,'form'])->name('login');Route::post('/admin/login',[AdminAuth::class,'login'])->name('admin.login.submit');});
Route::get('/admin/login-page',fn()=>redirect()->route('login'))->name('admin.login');

Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function(){
 Route::get('/',AdminDashboard::class)->name('dashboard');
 Route::get('home',[AdminHomePage::class,'edit'])->name('home.edit');
 Route::put('home',[AdminHomePage::class,'update'])->name('home.update');

 Route::middleware('role:superadmin,admin,editor')->group(function(){
  Route::resource('news',AdminNews::class)->except('show');
  Route::resource('events',AdminEvent::class)->except('show');
  Route::get('events/{event}/performances',[AdminEventPerformance::class,'index'])->name('events.performances.index');
  Route::post('events/{event}/performances',[AdminEventPerformance::class,'store'])->name('events.performances.store');
  Route::put('events/{event}/performances/{performance}',[AdminEventPerformance::class,'update'])->name('events.performances.update');
  Route::delete('events/{event}/performances/{performance}',[AdminEventPerformance::class,'destroy'])->name('events.performances.destroy');
  Route::resource('documents',AdminDocument::class)->except('show');
  Route::resource('pages',AdminPage::class)->except('show');
  Route::get('media',[AdminMedia::class,'index'])->name('media.index');
  Route::post('media',[AdminMedia::class,'store'])->name('media.store');
  Route::delete('media/{medium}',[AdminMedia::class,'destroy'])->name('media.destroy');
  Route::resource('galleries',AdminGallery::class)->except('show');
  Route::put('galleries/{gallery}/media/{medium}',[AdminGallery::class,'mediaUpdate'])->name('galleries.media.update');
  Route::delete('galleries/{gallery}/media/{medium}',[AdminGallery::class,'detach'])->name('galleries.media.detach');
  Route::delete('galleries/{gallery}/media/{medium}/file',[AdminGallery::class,'destroyMedia'])->name('galleries.media.destroy');
  Route::resource('feedback',AdminFeedback::class)->only(['index','show','update','destroy']);
  Route::resource('music',AdminMusic::class)->only(['index','store','update','destroy']);
  Route::get('music-library',[AdminMusicLibrary::class,'index'])->name('music-library.index');
  Route::post('music-library/compositions',[AdminMusicLibrary::class,'storeComposition'])->name('music-library.compositions.store');
  Route::delete('music-library/compositions/{composition}',[AdminMusicLibrary::class,'destroyComposition'])->name('music-library.compositions.destroy');
  Route::post('music-library/sheets',[AdminMusicLibrary::class,'storeSheet'])->name('music-library.sheets.store');
  Route::delete('music-library/sheets/{sheet}',[AdminMusicLibrary::class,'destroySheet'])->name('music-library.sheets.destroy');
 });

 Route::middleware('role:superadmin,admin,editor,teacher')->group(function(){
  Route::resource('departments',AdminDepartment::class)->except('show');
  Route::resource('teachers',AdminTeacher::class)->except('show');
  Route::resource('students',AdminStudent::class)->except('show');
  Route::resource('programs',AdminProgram::class)->except('show');
  Route::resource('achievements',AdminAchievement::class)->except('show');
  Route::resource('collectives',AdminCollective::class)->except('show');
  Route::resource('competitions',AdminCompetition::class)->except('show');
  Route::resource('schedule',AdminSchedule::class)->except('show');
  Route::resource('admission-campaigns',AdminAdmission::class)->except('show');
 });

 Route::middleware('role:superadmin,admin')->group(function(){
  Route::resource('menus',AdminMenu::class)->except('show');
  Route::patch('menus/{menu}/quick',[AdminMenu::class,'quick'])->name('menus.quick');
  Route::get('settings',[AdminSetting::class,'edit'])->name('settings.edit');
  Route::put('settings',[AdminSetting::class,'update'])->name('settings.update');
 });

 Route::middleware('role:superadmin')->group(function(){Route::resource('users',AdminUser::class)->except('show');});
 Route::post('/logout',[AdminAuth::class,'logout'])->name('logout');
});
