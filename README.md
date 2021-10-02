# 📣 About 

this repo conatines methode allow user uplaod file using Angular and symfony4.4  and CRUD for an entitie


# 📣 Usage 
In the Controller symfony:
```Symfony

 /**
     * @Route("/upload", name="uploadimag", methods={"GET","POST"})
     */
    public function upload(Request $request): Response
    {
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $request->get("image"));
      
        $image_type_aux = explode("image/", $image_parts[0]);
         
        $image_type = $image_type_aux[1];
       
        $image_base64 = base64_decode($image_parts[1]);
        
        $file = $folderPath.uniqid() . '.png';
        
        file_put_contents($file, $image_base64);
        $imagename= substr($file, 8, strlen($file));;
        
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($imagename);
        return new JsonResponse( $formatted);
    }
```
In component.ts symfony: 
in your FormController 
```Angular
  fileSource: new FormControl('', [Validators.required]),
```
Add  onFileChange finction

```Angular
 onFileChange(event: any) {
    const reader = new FileReader();

    if (event.target.files && event.target.files.length) {
      const [file] = event.target.files;

      reader.readAsDataURL(file);

      reader.onload = () => {
        this.imageSrc = reader.result as string;

        this.myform.patchValue({
          fileSource: reader.result,
        });
      };
    }
  }
  ```
  Your Function with other attributes in your Form
  ```Angular

   add(): void {
    const data = this.myform.value;
    const formData = new FormData();
    console.log(data.fileSource)
    formData.append('image', data.fileSource);
    this.http
      .post('http://127.0.0.1:8000/article/upload', formData)
      .subscribe((resu) => {
       let art={
         "title":data.title,
          "category":data.category,
          "description":data.description,
          "image":resu

       }
        console.log(resu)
        this.articleService.addArticle(art).subscribe((res) => {
          alert('ok !');
          this.refresh();
        });
      });
  }
  ```
  
# 📝 Credit 
Created by Omar Jmai


# 👨🚀Show Your support 
Give a ⭐️ if this project helped you!

