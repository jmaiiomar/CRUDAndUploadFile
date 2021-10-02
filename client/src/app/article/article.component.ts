import { Component, OnInit } from '@angular/core';
import { NgbCarouselConfig } from '@ng-bootstrap/ng-bootstrap';
import { ArticleService } from '../service/article.service';

@Component({
  selector: 'app-article',
  templateUrl: './article.component.html',
  styleUrls: ['./article.component.css'],
  providers: [NgbCarouselConfig]  // add NgbCarouselConfig to the component providers

})
export class ArticleComponent implements OnInit {
  p: number = 1;
   articleList:any=[];
  constructor(private articleService :ArticleService) { }

  ngOnInit(): void {
    this.articleService.getArticle().subscribe((res) => {
      this.articleList = res.data;
    });
  }
  updatelist(enable:any){
    if(enable=="true")
    {
      this.articleService.getArticle().subscribe((res) => {
        this.articleList = res.data;
      });
    }
  }

}
