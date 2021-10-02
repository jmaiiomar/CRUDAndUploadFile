import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {NgxPaginationModule} from 'ngx-pagination'; // <-- import the module
import { AppComponent } from './app.component';
import { ArticleComponent } from './article/article.component';
import { NewArticleComponent } from './addarticle/new-article/new-article.component';
import { DetailsArticleComponent } from './detailsArticle/details-article/details-article.component';
import { AppRoutingModule } from './app-routing.module';
import { UpdateArticleComponent } from './updateArticle/update-article/update-article.component';

@NgModule({
  declarations: [
    AppComponent,
    ArticleComponent,
    NewArticleComponent,
    DetailsArticleComponent,
    UpdateArticleComponent
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
    NgxPaginationModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }