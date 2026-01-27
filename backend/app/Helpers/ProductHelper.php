<?php

namespace App\Helpers;

class ProductHelper
{
    public static function format($product, $relatedProducts = null)
    {
        $details = $product->details instanceof \Illuminate\Support\Collection
            ? $product->details->first()
            : $product->details;

        $gallery = array_filter([
            $product->image,
        ]);

        if ($details) {
            $detailImages = array_filter([
                $details->image1,
                $details->image2,
                $details->image3,
                $details->image4,
            ]);
            $gallery = array_merge($gallery, $detailImages);
            $gallery = array_values(array_filter($gallery));
        }

         $colors = $product->variations->pluck('color')
            ->map(function ($color) {
                return $color ? trim($color) : null;
            })
            ->filter(function ($color) {
                return !is_null($color) && $color !== '';
            })
            ->unique()
            ->values()
            ->toArray();

        $sizes = $product->variations->pluck('size')
            ->map(function ($size) {
                return $size ? trim($size) : null;
            })
            ->filter(function ($size) {
                return !is_null($size) && $size !== '';
            })
            ->unique()
            ->values()
            ->toArray();

        $defaultSku = $product->variations->isNotEmpty() 
        ? $product->variations->first()->sku 
        : ($details->sku ?? null);

        $variationsArray = $product->variations->map(function($variation) use ($product) {
            return [
                'id' => $variation->id,
                'color' => $variation->color ?? null,
                'size' => $variation->size ?? null,
                'sku' => $variation->sku,
                'price' => $variation->price ?? $product->price,
                'stock' => $variation->stock,
                'image' => $variation->image,

                'is_available' => ($variation->stock > 0),
                'has_color' => !empty($variation->color),
                'has_size' => !empty($variation->size),
            ];
        })->values()->toArray();

         $variationBasedSku = null;
        if ($product->variations->isNotEmpty()) {
            $firstVariation = $product->variations->first();
            $variationBasedSku = $firstVariation->sku ?? null;
        }

        $reviews = $product->reviews
            ? $product->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'name' => $review->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            })->values()
            : [];

            $related = [];

            if ($relatedProducts && $relatedProducts->isNotEmpty()) {
                $related = $relatedProducts->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'title' => $p->title,
                        'slug' => $p->slug,
                        'price' => $p->price,
                        'image' => $p->image,
                        'star' => round($p->reviews->avg('rating') ?? 0, 1),
                        'review_count' => $p->reviews->count(),
                    ];
                })->values();
            }

        return [
            'id'            => $product->id,
            'title'         => $product->title,
            'slug'          => $product->slug,
            'price'         => $product->price,
            'stock'         => $product->stock,
            'discount'      => $product->discount,
            'discount_type' => $product->discount_type,
            'image'         => $product->image,
            'short_desc'    => $product->short_desc,
            'star'          => $product->star,
            'remarks'          => $product->remarks,

            'related_products' => $related,

            'reviews'       => $reviews,
            'review_count' => count($reviews),

            'brand'     => $product->brand,
            'category'  => $product->category,
            'sliders'   => $product->sliders,

            'gallery' => $gallery,
            'colors'  => $colors,
            'sizes'   => $sizes,
            'has_variations' => $product->variations->isNotEmpty(),
            'has_colors' => !empty($colors),
            'has_sizes' => !empty($sizes),
            'variations' => $variationsArray,

            'details' => $details ? [
                'image1' => $details->image1,
                'image2' => $details->image2,
                'image3' => $details->image3,
                'image4' => $details->image4,
                'sku' => $details->sku,
                'description' => $details->description,
            ] : null,

            'sku'         => $variationBasedSku ?? ($details->sku ?? null),
            'description' => $details->description ?? null,

            'meta' => [
                'requires_color' => !empty($colors),
                'requires_size' => !empty($sizes),
                'has_gallery' => !empty($gallery),
                'variation_count' => $product->variations->count(),
            ]
        ];
    }
}