<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comments;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            ["comment" => "Excellent performance, keep up the good work!", "category" => "academic"],
            ["comment" => "Shows great enthusiasm for learning and participation.", "category" => "academic"],
            ["comment" => "Has made remarkable improvement this term.", "category" => "academic"],
            ["comment" => "Consistently demonstrates strong academic skills.", "category" => "academic"],
            ["comment" => "Shows leadership qualities in group activities.", "category" => "behavior"],
            ["comment" => "Very attentive in class and eager to contribute.", "category" => "academic"],
            ["comment" => "Punctual and responsible with assignments.", "category" => "behavior"],
            ["comment" => "Creative and thinks outside the box.", "category" => "academic"],
            ["comment" => "Hardworking and determined to succeed.", "category" => "academic"],
            ["comment" => "Respectful to teachers and peers.", "category" => "behavior"],
            ["comment" => "Always comes prepared for class.", "category" => "academic"],
            ["comment" => "Motivated and demonstrates a positive attitude.", "category" => "behavior"],
            ["comment" => "A role model for other students.", "category" => "behavior"],
            ["comment" => "Excellent communication skills.", "category" => "academic"],
            ["comment" => "Shows perseverance in difficult tasks.", "category" => "academic"],
            ["comment" => "Actively participates in class discussions.", "category" => "academic"],
            ["comment" => "Takes pride in completing assignments neatly.", "category" => "academic"],
            ["comment" => "Shows potential to achieve even greater results.", "category" => "academic"],
            ["comment" => "Well-organized and manages time effectively.", "category" => "behavior"],
            ["comment" => "Demonstrates a strong grasp of concepts taught.", "category" => "academic"],
            ["comment" => "Curious and asks thoughtful questions.", "category" => "academic"],
            ["comment" => "Responsible and reliable in group work.", "category" => "behavior"],
            ["comment" => "Shows confidence in presenting ideas.", "category" => "academic"],
            ["comment" => "Pays attention to detail in assignments.", "category" => "academic"],
            ["comment" => "Always willing to help classmates.", "category" => "behavior"],
            ["comment" => "Self-motivated and independent learner.", "category" => "academic"],
            ["comment" => "Respectful and courteous at all times.", "category" => "behavior"],
            ["comment" => "Has a positive impact on classroom environment.", "category" => "behavior"],
            ["comment" => "Quick learner with good retention skills.", "category" => "academic"],
            ["comment" => "Consistently exceeds expectations.", "category" => "academic"],
            ["comment" => "Shows maturity beyond their age.", "category" => "behavior"],
            ["comment" => "Displays confidence in problem solving.", "category" => "academic"],
            ["comment" => "Brings creativity into school projects.", "category" => "academic"],
            ["comment" => "Encourages peers with positive attitude.", "category" => "behavior"],
            ["comment" => "Enthusiastic in extra-curricular activities.", "category" => "behavior"],
            ["comment" => "Demonstrates consistent academic growth.", "category" => "academic"],
            ["comment" => "Listens attentively and follows instructions.", "category" => "academic"],
            ["comment" => "Shows diligence in completing homework.", "category" => "academic"],
            ["comment" => "Adapts well to new challenges.", "category" => "behavior"],
            ["comment" => "Sets a great example for classmates.", "category" => "behavior"],
            ["comment" => "Has strong analytical and critical thinking skills.", "category" => "academic"],
            ["comment" => "Takes responsibility for their learning.", "category" => "academic"],
            ["comment" => "A polite and cooperative student.", "category" => "behavior"],
            ["comment" => "Always strives for excellence.", "category" => "academic"],
            ["comment" => "Displays enthusiasm for reading and research.", "category" => "academic"],
            ["comment" => "Resilient in overcoming academic challenges.", "category" => "academic"],
            ["comment" => "Demonstrates teamwork and collaboration.", "category" => "behavior"],
            ["comment" => "Improving steadily across all subjects.", "category" => "academic"],
            ["comment" => "Exhibits patience and focus in class tasks.", "category" => "behavior"],
            ["comment" => "Maintains a cheerful and positive outlook.", "category" => "behavior"]
        ];
        foreach ($comments as $comment){
            Comments::create($comment);
        }
       
    }
}
