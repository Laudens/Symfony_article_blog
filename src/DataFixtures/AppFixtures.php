<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $article = new Article();
                $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')))
                    ->setCategory($category);

                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();
                    $content = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
                    $days = (new \DateTimeImmutable())->diff($article->getCreateAt())->days;

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreateAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-' . $days . 'days')))
                        ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
