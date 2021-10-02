import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AppComponent } from './app.component';
import { ArticleComponent } from './article/article.component';
import { DetailsArticleComponent } from './detailsArticle/details-article/details-article.component';

const routes: Routes = [
  { path: '', component: ArticleComponent },
  { path: 'details/:id', component: DetailsArticleComponent },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
